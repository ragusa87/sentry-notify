<?php

namespace AppBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class TestDeprecatedCommand extends ContainerAwareCommand
{
    public function configure()
    {
        $this->setName("notify:send");
    }

    public function run(InputInterface $input, OutputInterface $output)
    {
        @trigger_error("Custom error message", E_USER_DEPRECATED);

        $this->getContainer()->get("logger")->warning("This is a notification message from command ".$this->getName());

    }
}