<?php

namespace DIPcms\LightTextManager;

use Nette;
use Nette\Http\FileUpload;
use DIPcms\LightTextManager\Entits\Texts;

class TextManager extends BaseModel{
    
        /**
         *
         * @var string 
         */
        public $table_name = '\DIPcms\LightTextManager\Entits\Texts';
        
        
        /**
         * 
         * @param string $name
         * @param string $page
         * @param string $text
         * @return Texts
         */
        public function addText($name, $page, $text){
            $text_ = new Texts();
            $text_->name = $name;
            $text_->page = $page;
            $text_->text = $text;
            $this->em->persist($text_);
            $this->em->flush();
            return $text_;
        }
        
        /**
         * 
         * @param type $name
         * @return Texts
         */
        public function getText($name){
            return $this->entit->findOneBy(array('name'=>$name));
        }
        
        
        /**
         * 
         * @return ArrayObject[]|Texts
         */
        public function getTexts(){
            return $this->entit->findAll();
        }
        
        
        /**
         * 
         * @param string $name
         */
        public function remove($name){
            $text = $this->getText($name);
            if($text){
                $this->em->remove($text);
                $this->em->flush();
            }
        }
        
        
        
        /**
         * 
         * @param string $name
         * @param string $page
         * @param string $text
         * @return Texts
         */
        public function editText($name, $page, $text){
            $text_ = $this->getText($name);
            $text_->name = $name;
            $text_->page = $page;
            $text_->text = $text;
            $this->em->persist($text_);
            $this->em->flush();
            return $text_;
        }
        
        
        
        /**
         * 
         * @param string $name
         * @return boolean
         */
        public function issetText($name){
            $text = $this->getText($name);
            if($text){
                return true;
            }
            return false;
        }
        

}
 