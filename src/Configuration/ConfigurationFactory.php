<?php

namespace Permafrost\CoverageCheck\Configuration;

use Symfony\Component\Console\Input\InputInterface;

class ConfigurationFactory
{
    public static function create(InputInterface $input): Configuration
    {
        $filename = $input->getArgument('filename');
        $requireMode = $input->hasOption('require') && $input->getOption('require') !== null;
        $percentage = $requireMode ? (float)$input->getOption('require') : null;
        $displayCoverageOnly = $input->hasOption('coverage-only') && $input->getOption('coverage-only') === true;
        $precision = $input->hasOption('precision') ? (int)$input->getOption('precision') : 4;
        $metricField = 'element';

        if ($input->hasOption('metric') && $input->getOption('metric') !== null) {
            $metricField = $input->getOption('metric');
        }

        return new Configuration($filename, $requireMode, $percentage, $displayCoverageOnly, $metricField, $precision);
    }
}
