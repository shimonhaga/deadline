#!/usr/bin/env php
<?php

namespace Shimoning\Deadline;

require_once __DIR__ . '/vendor/autoload.php';

echo __NAMESPACE__ . " shell\n";
echo "-----\nexample:\n";
echo "  \$deadline = new NextMonthFirstBusinessDay(2020, 8, 15);\n";
echo "  \$deadline(12);\n";
echo "  \$deadline->isExceeded();\n";
echo "-----\n\n";

$sh = new \Psy\Shell();

$sh->addCode(sprintf("namespace %s;", __NAMESPACE__));

$sh->run();

echo "\n-----\nBye.\n";
