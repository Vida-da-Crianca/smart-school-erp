<?php

namespace Packages\Commands;



use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

/**
 * Base Command
 *
 * @package     Craftsman
 * @author      David Sosa Valdes
 * @link        https://github.com/davidsosavaldes/Craftsman
 * @copyright   Copyright (c) 2016, David Sosa Valdes.
 * @version     1.0.0
 */
abstract class BaseCommand extends Command
{
    /**
     * Console command name
     * @var string
     */
    protected $name;

    /**
     * Console command description
     * @var string
     */
    protected $description;

    /**
     * InputInterface instance
     * @var object
     */
    protected $_input;

    /**
     * OutputInterface instance
     * @var object
     */
    protected $_output;

    protected $exceptions = ['migrate', 'migrate:rollback', 'schedule:run'];

    /**
     * Style instance
     * @var object
     */
    protected $_style;

    /**
     * Configure default attributes
     */
    protected function configure()
    {
        $this
            ->setName($this->name)
            ->setDescription($this->description);
    }

    /**
     * Initialize the objects
     * 
     * @param  InputInterface  $input 
     * @param  OutputInterface $output
     */
    protected function initialize(InputInterface $input, OutputInterface $output)
    {
        $this->_input  = $input;
        $this->_output = $output;
        $this->_style  = new SymfonyStyle($input, $output);
    }

    /**
     * Execute the command
     * 
     * @param InputInterface  $input  
     * @param OutputInterface $output 
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        try {
            $this->CI->load->model('eloquent/ProcessControl');

        
           

            if (method_exists($this, 'start')) {
                $isRunning =  in_array($this->name, $this->exceptions) ? false : true;
                $locked = !$isRunning  ? 0 : \ProcessControl::where('name', $this->name)->count();
                
                if ($locked > 0) {
                    dump($this->name .' is running...');
                    return 0;
                }
                if ($isRunning){
                    \ProcessControl::create(['name' => $this->name, 'status' => 'running']);
                }
                   
                $this->start();

                if ($isRunning) {
                    sleep(3);
                    \ProcessControl::where('name', $this->name)->delete();
                }
            } else {
                throw new \RuntimeException("Command is not set correctly.");
            }
        } catch (\Exception $e) {
            \ProcessControl::where('name', $this->name)->delete();
            $this->error($e->getMessage());
        }
        return 0;
    }

    public function runnerWithControl()
    {
    }

    /**
     * Call some methods easily
     * 
     * @param  string $name      
     * @param  mixed  $arguments   
     */
    public function __call($name = '', $arguments = NULL)
    {
        switch ($name) {
            case 'title':
            case 'section':
            case 'text':
            case 'listing':
            case 'table':
            case 'newLine':
            case 'note':
            case 'caution':
            case 'progressStart':
            case 'progressAdvance':
            case 'progressFinish':
            case 'ask':
            case 'askHidden':
            case 'confirm':
            case 'choice':
            case 'success':
            case 'warning':
            case 'error':
            case 'comment':
                return call_user_func_array(array($this->_style, $name), $arguments);

            case 'getArgument':
                return call_user_func_array(array($this->_input, 'getArgument'), $arguments);

            case 'getOption':
                return call_user_func_array(array($this->_input, 'getOption'), $arguments);
        }
    }
}
