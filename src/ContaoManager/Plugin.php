<?php
namespace Delirius\Linkliste\ContaoManager;

use Contao\CoreBundle\ContaoCoreBundle;
use Contao\ManagerPlugin\Bundle\BundlePluginInterface;
use Contao\ManagerPlugin\Bundle\Parser\ParserInterface;
use Contao\ManagerPlugin\Bundle\Config\BundleConfig;
use Delirius\Linkliste\DeliriusLinkliste;

class Plugin implements BundlePluginInterface
{
    /**
     * {@inheritdoc}
     */
    public function getBundles(ParserInterface $parser)
    {
        return [
            BundleConfig::create(DeliriusLinkliste::class)
            ->setLoadAfter(['Contao\CoreBundle\ContaoCoreBundle'])
        ];
    }
}
?>
