<?php
declare(strict_types=1);

namespace TheCodeFighters\Bundle\AuditorFramework\Common\Types\Infrastructure\Ui\Cli;

use DateTime;
use Exception;
use TheCodeFighters\Bundle\AuditorFramework\Common\Utils\Assertion\InfrastructureAssertion;
use Prooph\Bundle\EventStore\Command\AbstractProjectionCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class ProjectionRunCommandDecorator extends AbstractProjectionCommand
{
    const OPTION_RUN_ONCE = 'run-once';
    const DATE = "date";

    protected function configure()
    {
        parent::configure();
        $this
            ->setName('auditor_framework:projection:run')
            ->setDescription('Runs a projection with date')
            ->addOption(static::OPTION_RUN_ONCE, 'o', InputOption::VALUE_NONE, 'Loop the projection only once, then exit')
            ->addOption(static::DATE, 'd', InputOption::VALUE_OPTIONAL, 'date, This field sets events included in history to rehidrate Aggregate');
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return int|void|null
     * @throws Exception
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $keepRunning = ! $input->getOption(static::OPTION_RUN_ONCE);
        $output->writeln(
            sprintf(
                '<action>Starting projection <highlight>%s</highlight>. Keep running: <highlight>%s</highlight></action>', $this->projectionName,
                $keepRunning === true ? 'enabled' : 'disabled'
            )
        );

        if(is_null($input->getOption(static::DATE))){
            $date = new DateTime();
        }else{
            InfrastructureAssertion::isValidDateTimeAtomString($input->getOption(static::DATE));
            $date = new DateTime($input->getOption(static::DATE));
        }

        $projector = $this->projection->project($this->projector, $date);
        $projector->reset();
        $projector->run((bool) $keepRunning);
        $output->writeln(sprintf('<action>Projection <highlight>%s</highlight> completed.</action>', $this->projectionName));
    }
}
