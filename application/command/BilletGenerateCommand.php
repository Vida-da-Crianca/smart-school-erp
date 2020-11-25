<?php

namespace Application\Command;

use Application\Core\BankInterPayment;
use Billet_eloquent;
use Illuminate\Database\Eloquent\Collection;
use Packages\Commands\BaseCommand;
use stdClass;
use Illuminate\Database\Capsule\Manager as DB;


class BilletGenerateCommand extends BaseCommand
{

    protected $name = 'billet:generate';

    protected $description = '';

    protected $CI;


    protected  $forGenerateItems = [];

    public function __construct($CI)
    {
        $this->CI = $CI;
        parent::__construct();
    }

    protected function configure()
    {
        $this
            ->setName($this->name)
            ->setDescription($this->description);
    }

    protected function start()
    {

        $this->CI->load->library('bank_payment_inter');
        $this->CI->load->model('eloquent/Billet_eloquent');
        DB::beginTransaction();

        $billets = \Billet_eloquent::whereNull('bank_bullet_id')
            ->with(['feeItems', 'student'])
            ->get()->groupBy('user_id');
        foreach ($billets as $row) {
            $group = $row->groupBy('due_date');
            $this->buildByOnDueDate($group);
        }
    }


    protected function callGrouped($data, $callback)
    {
        foreach ($data as $row) {
            $callback($row);
        }
    }


    public function buildByOnDueDate($data)
    {

        foreach ($data as $row) {

            $student = null;
            $descriptions = [];
            $billet = new \stdClass();
            $billet->price = 0;
            $billet->due_date = null;
            $billet->description = null;
            $billet->id = [];
            $billet->custom_number = substr(md5(rand(10, 1000) . date('YmdHis')), 0, 10);
            $this->callGrouped($row, function ($item) use (&$billet, &$student, &$descriptions) {

                $billet->id[] = $item->id;
                $first = $item->feeItems()->first();
                $billet->price +=  $first->amount;
                $billet->due_date = $item->due_date;
                $student = $item->student;
                $descriptions[] =  sprintf('%s - %s - R$ %s', $student->full_name, $first->title, number_format($first->amount, 2, ',', '.'));
            });

            if ($billet->id == 0) continue;

            $payment = $this->buildOptionsStudentPayment($student);
            $billet->description = implode(PHP_EOL, $descriptions);
            $this->buildOptionsBilletPayment($payment, $billet);

            $this->push($payment, function ($options) use ($billet) {
                //  if($id == null) return;
                $this->onPush($options, $billet);
            });
        }
    }


    public function onPush($options, $billet)
    {   if(!$options->success) return;
        \Billet_eloquent::whereIn('id', $billet->id)
            ->update([
                'custom_number' => $billet->custom_number,
                'bank_bullet_id' => $options->billet->number,
            ]);

        DB::commit();
    }

    public function buildOptionsStudentPayment($student)
    {
        $payment = new BankInterPayment;
        $payment->user =  $student->guardian_name;
        $payment->user_document =  $student->guardian_document;
        $payment->address = $student->guardian_address;
        $payment->address_state = $student->guardian_state;
        $payment->address_district = $student->guardian_district;
        $payment->address_city = $student->guardian_city;
        $payment->address_number = $student->guardian_address_number;
        $payment->address_postal_code = $student->guardian_postal_code;

        return $payment;
    }

    public function buildOptionsBilletPayment(&$payment, &$billet)
    {

        $payment->price = $billet->price;
        $payment->date_payment = $billet->due_date;
        $payment->description =  $billet->description;
        $payment->your_number  = $billet->custom_number;
    }


    public function push($payment, \Closure $callback)
    {
        $this->CI->bank_payment_inter->create($payment, $callback);
    }
}
