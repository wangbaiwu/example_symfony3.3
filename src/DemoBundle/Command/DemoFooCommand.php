<?php

namespace DemoBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\EventDispatcher\EventDispatcher;
use DemoBundle\EventSubscriber\BookSubscriber;
use DataBundle\EventSubscriber\DataSubscriber;
use DemoBundle\Event\BookEvent;
use DemoBundle\Event\UserEvent;
use DemoBundle\EventListener\UserListener;
use DemoBundle\EventListener\AcmeListener;

class DemoFooCommand extends ContainerAwareCommand
{
    /**
     *
     */
    protected function configure()
    {
        //bin/console demo:foo --bar=a foo=c
        $this
            ->setName('demo:foo')
            ->setDescription('demo:foo description')
            ->addArgument('foo', InputArgument::REQUIRED, 'foo argument is needed')
            ->addOption('bar','b',InputOption::VALUE_REQUIRED,'bar is need',1)
            ->setHelp('demo:foo help context')
        ;
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return int
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $output->writeln([
            'Command result.',
            '==============',
            var_export($input->getOptions(),true),
            var_export($input->getArguments(),true),
            //var_export($this->getUser(1),true)

        ]);
        //$this->disBookEvent();
        $this->disUserEvent();
        return 0;
    }

    /**
     * @param int $userId
     * @return mixed
     */
    protected function getUser($userId=0)
    {
        $conn=$this->getContainer()->get('doctrine.dbal.pdo_mysql_connection');
        $row=$conn->fetchColumn("select name from user where id=:id",["id"=>$userId]);
        return $row;
    }

    /**
     * DISPATCH BOOK EVENT
     */
    protected function disBookEvent()
    {
        $dispatcher = new EventDispatcher();
        $subscriber = new BookSubscriber();
        $dataSubscriber = new DataSubscriber();

        $dispatcher->addSubscriber($subscriber);
        $dispatcher->addSubscriber($dataSubscriber);
        $dispatcher->dispatch("english.name", new BookEvent());
        $dispatcher->dispatch("chinese.name");
        $dispatcher->removeSubscriber($subscriber);
        $dispatcher->dispatch("math.name");
    }

    /**
     * DISPATCH USER EVENT
     */
    protected function disUserEvent()
    {
        $dispatcher = new EventDispatcher();
        $conn=$this->getContainer()->get('doctrine.dbal.pdo_mysql_connection');
        $dispatcher->addListener("user.name", [new UserListener(),'onNameAction'],1);
        $dispatcher->dispatch("user.name", new UserEvent($conn));
    }

}
