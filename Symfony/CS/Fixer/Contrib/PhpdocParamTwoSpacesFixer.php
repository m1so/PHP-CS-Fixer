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

namespace Symfony\CS\Fixer\Contrib;

use Symfony\CS\AbstractFixer;
use Symfony\CS\DocBlock\DocBlock;
use Symfony\CS\Tokenizer\Tokens;

/**
 * @author Michal Baumgartner <miso.baumgartner@gmail.com>
 */
class PhpdocParamTwoSpacesFixer extends AbstractFixer
{
    /**
     * {@inheritdoc}
     */
    public function fix(\SplFileInfo $file, $content)
    {
        $tokens = Tokens::fromCode($content);

        foreach ($tokens->findGivenKind(T_DOC_COMMENT) as $token) {
            $doc = new DocBlock($token->getContent());
            $annotations = $doc->getAnnotationsOfType('param');

            if (empty($annotations)) {
                continue;
            }

            foreach ($annotations as $annotation) {
                $line = $doc->getLine($annotation->getStart());
                $typeIndex = strpos($line->getContent(), '@param');
                // Text before and after (including) '@type'
                $textBefore = substr($line->getContent(), 0, $typeIndex);
                $typeText = substr($line->getContent(), $typeIndex);

                if (sizeof(explode($typeText, '  ')) === 3) {
                    continue;
                }

                // Array of up to 3 elements ('@type', 'actual type', 'rest') split by whitespaces starting from '@type'
                $lineArr = preg_split('/\s+/', $typeText, 3);
                // Glue previous array with 2 spaces
                $line->setContent($textBefore.join('  ', $lineArr));
            }

            $token->setContent($doc->getContent());
        }

        return $tokens->generateCode();
    }

    /**
     * {@inheritdoc}
     */
    public function getDescription()
    {
        return '@param should be always separated by two spaces';
    }
}
