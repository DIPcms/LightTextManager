<?php


/**
 * Description of Routing
 *
 * @author Mykola Chomenko <mykola.chomenko@dipcom.cz>
 */
namespace DIPcms\LightTextManager\Macros;

use Nette;
use Latte\MacroNode;
use Latte\PhpWriter;
use Latte\Engine;
use DIPcms\LightTextManager\TextManager;

class Macros extends Nette\Object{
        
        /**
         *
         * @var TextManager
         */
        public $textManager;
        
    
        
        
        public function __construct(TextManager $TextManager){
            $this->textManager = $TextManager;
        }
        
        
        

	public static function addMacro(Engine $latte, self $macros){
           
            $macroSet = new \Latte\Macros\MacroSet($latte->getCompiler());
            $macroSet->addMacro('text', null, array($macros, 'endGetText'), array($macros, 'createMacroGetText'));

	}
        
        
         
        
        
        public function createMacroGetText(MacroNode $node, PhpWriter $writer){
            
            return $writer->write('echo $__LightTextManager_macros->getText(%node.array, $presenter)');
        }
        
        public function endGetText(MacroNode $node, PhpWriter $writer){
            
            $content = htmlspecialchars($node->content);
            $node->content =  "";
            return $writer->write('echo $__LightTextManager_macros->getText(%node.array, $presenter, "'.$content.'")');
            
        }
        
        
        public function getText($params, \Nette\Application\UI\Presenter $presenter, $default_text = null){

            if(!isset($params[0])){
                throw new \Exception("gettext macro must define 1 parameter {getText 'textName'}");
            }
            $name = $params[0];
            $default_text = htmlspecialchars_decode($default_text);
            
            $text = $this->textManager->getText($name);
            $texy = new \Texy\Texy();
            if(!$text){
                $this->textManager->addText($name, $presenter->name.':'.$presenter->getAction(), $default_text);
                return $texy->process($default_text);
                
            }else{
                return $texy->process($text->text);
            }

        }
        

        
}

