<?php

/*
 * This file is part of PHP CS Fixer.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *     Dariusz Rumiński <dariusz.ruminski@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Symfony\CS\Tests\Fixer\Contrib;

use Symfony\CS\Tests\Fixer\AbstractFixerTestBase;

/**
 * @author Michal Baumgartner <miso.baumgartner@gmail.com>
 */
class PhpdocParamTwoSpacesFixerTest extends AbstractFixerTestBase
{
    /**
     * @dataProvider provideCases
     */
    public function testFix($expected, $input = null)
    {
        $this->makeTest($expected, $input);
    }

    public function provideCases()
    {
        return array(
            array(
                '<?php
    /**
     * @return array Whatever
     */',
            ),
            array(
                '<?php
    /**
     * @param  string  Hello!
     */',
                '<?php
    /**
     * @param string Hello!
     */',
            ),
            array(
                '<?php
    /**
     * @param  string  Hello my name is...
     */',
                '<?php
    /**
     * @param string Hello my name is...
     */',
            ),
            array(
                '<?php
    /**
     * @param  string  Hello weird indentation
     */',
                '<?php
    /**
     * @param            string                          Hello weird indentation
     */',
            ),
            array(
                '<?php /** @param  string  Hello! */',
                '<?php /** @param string Hello! */',
            ),

        );
    }
}
