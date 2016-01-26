<?php

/**
 *
 * @author Mykola Chomenko <mykola.chomenko@dipcom.cz>
 */

namespace DIPcms\LightTextManager\DI;


use Nette;
use Nette\DI\CompilerExtension;

class LightTextManagerExtension extends CompilerExtension{
    
   
    
    public function loadConfiguration() {
        
        $builder = $this->getContainerBuilder();
        
        $builder->addDefinition($this->prefix('maping'))
		->setClass('DIPcms\LightTextManager\Maping')
                ->setInject(false);
        
        
        $manager = $builder->addDefinition($this->prefix('manager'))
		->setClass('DIPcms\LightTextManager\TextManager');
        
        $builder->addDefinition($this->prefix('macros'))
            ->setClass('DIPcms\LightTextManager\Macros\Macros',array(
                $manager
            ))
            ->setAutowired(FALSE)
            ->setInject(FALSE);
        
    }
    
   
    
    public function beforeCompile(){
        
        $builder = $this->getContainerBuilder();
        
        $cache = $builder->getDefinition('doctrine.cache.default.metadata');
        $reader = $builder->getDefinition('annotations.reader');
        $builder->getDefinition('doctrine.default.metadataDriver')
                ->addSetup('DIPcms\LightTextManager\Maping::addDoctrineMaping($service, ?,?,?)', array($this->prefix('@maping'), $cache, $reader));
        
        $builder->getDefinition('latte.templateFactory')
                ->addSetup('$service->setDefaultTemplateValue("__LightTextManager_macros",?);', array(
                    $this->prefix('@macros')
                ));
        
        $builder->getDefinition('nette.latteFactory')
                ->addSetup('DIPcms\LightTextManager\Macros\Macros::addMacro($service,?)', array($this->prefix('@macros')));
    }
    
    
    
     /**
     * @param \Nette\Configurator $configurator
     */
    public static function register(Nette\Configurator $configurator){
        
        $configurator->onCompile[] = function ($config, Nette\DI\Compiler $compiler){
                $compiler->addExtension('userManager', new UserManagerExtension());
        };
    } 
    
  
}
