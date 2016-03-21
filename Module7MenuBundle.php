<?php
/**
 * This Bundle builds a reusable Menu Service infrasstructure
 */

namespace Module7\MenuBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Module7\CommonsBundle\DependencyInjection\Compiler\FormPass;

class Module7MenuBundle extends Bundle {

  /**
   * {@inheritdoc}
   */
  public function build(ContainerBuilder $container)
  {
    parent::build($container);
    $container->addCompilerPass(new FormPass());
  }

}