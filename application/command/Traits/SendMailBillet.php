<?php

namespace Application\Command\Traits;

use Illuminate\Database\Eloquent\Collection;

use Carbon\Carbon;
use Closure;

// use Illuminate\Database\Eloquent\Collection;
// use Illuminate\Support\Collection;

trait SendMailBillet
{



    public function handleSendMail($billet, Closure  $callable = null)
    {    $this->CI->load->library(['bank_payment_inter', 'mailer']);
        $body =  $billet->body_json;
        $first = $billet->feeItems()->first();

        $options = [
            'name' => $billet->student->guardian_name,
            'email' => getenv('ENVIRONMENT') == 'development' ?  'contato@carlosocarvalho.com.br' : $billet->student->guardian_email,
            'id' => $billet->bank_bullet_id,
            'link' => site_url('billet/live/' . $billet->bank_bullet_id),
            'code' => null,
            'file' => '',
            'due_date' =>  new \DateTime($billet->due_date),
            'items' => []
        ];
        $items = [];



        $billet->feeItems->each(function ($row) use (&$items, $billet, $first) {

            $body =  $row->body_json;
            $discount = sprintf('- Desc. R$ %s', number_format($body->fee_discount, 2, ',', '.'));
            $items[] = (object) [
                'billet' =>  $billet->bank_bullet_id,
                'name' => $billet->student->full_name,
                'due_date' => new \DateTime($billet->due_date),
                'description' => sprintf(
                    '%s - %s - R$ %s ',
                    $billet->student->full_name,
                    $first->title,
                    number_format($first->amount, 2, ',', '.'),
                    $body->fee_discount > 0 ? $discount : ''
                ),
                'price' =>  $first->amount - $body->fee_discount
            ];
        });
        $options['items'] = $items;

        // dump($options);
        $content = $this->CI->load->view('mailer/billet.tpl.php', $options,  TRUE);
        $status = $this->CI->mailer->send_mail( getenv('ENVIRONMENT') == 'development' ?  'contato@carlosocarvalho.com.br' : $billet->student->guardian_email, 'Envio de boletos', $content /**/);

        $callable(['status' => $status, 'data' =>  $options]);
    }
}
