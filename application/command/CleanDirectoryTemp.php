<?php

namespace Application\Command;

use Carbon\Carbon;
use Packages\Commands\BaseCommand;


class CleanDirectoryTemp extends BaseCommand
{

    protected $name = 'clean:directory';

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


        $dateTime = new \DateTime();
        $second = Carbon::create($dateTime->format('Y'), $dateTime->format('m'), $dateTime->format('d'), 0, 0);
        $first = Carbon::create($dateTime->format('Y'), $dateTime->format('m'), $dateTime->format('d'), 3, 0);

        $isValid = Carbon::create(
            $dateTime->format('Y'),
            $dateTime->format('m'),
            $dateTime->format('d'),
            $dateTime->format('H'),
            $dateTime->format('i')
        )->betweenIncluded($first, $second);
        if ($isValid)
            shell_exec('rm -rf /app/temp/*');
    }
}
