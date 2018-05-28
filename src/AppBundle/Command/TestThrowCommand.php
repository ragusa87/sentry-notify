<?php
/**
 * @author     Laurent Constantin <lconstantin@pubfac.com>
 * @copyright  Copyright (c) 2018 Publishing Factory SA (http://www.pubfac.com/)
 * @license    proprietary
 */

namespace AppBundle\Command;


use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class TestThrowCommand extends Command
{
    public function configure()
    {
        $this->setName("notify:throw");
    }

    public function run(InputInterface $input, OutputInterface $output)
    {
        throw new \RuntimeException("This is an exception");
    }
}