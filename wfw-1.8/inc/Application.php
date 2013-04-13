<?php

//inclue le model de l'application
require_once("php/class/bases/cApplication.php");


class Application extends cApplication
{
    //surcharge makeXMLView avec les paramétres du template principale
    public function makeXMLView($filename,$attributes,$template_file=NULL)
    {
        //status de la base de données
        $attributes["bdd_status"] = "Indisponible, vérifiez la configuration de l'application et l'installation de votre SGBD";
        
        if($this->getDB($db_iface)){
            $attributes["bdd_status"] = $db_iface->getServiceProviderName();
            $attributes["bdd_status"] .= " ( ".$this->getCfgValue("database", "name")." @ ".$this->getCfgValue("database", "server_adr")." : ".$this->getCfgValue("database", "port")." )";
        }
        
        return parent::makeXMLView($filename,$attributes,$template_file);
    }
    
    //surcharge makeXMLView avec les paramétres du template principale
    public function libraryFromDoxygen($doc,$path)
    {
        $class     = $doc->all(">compound[kind=class]");
        $interface = $doc->all(">compound[kind=interface]");
        $files     = $doc->all(">compound[kind=file]");

        // cree le catalogue
        $lib = new CodeLibrary();
        $lib->name = "wfw";
        $lib->description = "Webframework";

        if(!CatalogModule::createCatalog(
            $catalog,
            "CODE_LIBRARY",
            $lib
        )) return false;

        
        //crée les classes 
        echo("class\n");
        foreach($class as $key=>$node){
            $nameEl = $doc->one("name",$node);
            $refid  = $doc->getAtt($node,"refid");
            //echo("$nameEl->nodeValue, $refid\n");
            
            //importe le fichier XML
            $sub_doc = new XMLDocument();
            if($sub_doc->load("$path/$refid.xml")){
                echo("add class $nameEl->nodeValue ($refid)\n");
                if(!Application::classFromDoxygen($catalog,$refid,$sub_doc))
                    return false;
            }
            else    echo("can't open $path/$refid.xml\n");
        }
        /*
        //crée les interfaces 
        echo("interface\n");
        print_r($interface);
        
        //crée les globales
        echo("files\n");
        print_r($files);
*/
        return RESULT_OK();
    }
    
    //
    public function classFromDoxygen($catalog,$refid,$doc)
    {
        $classEl = $doc->one("compounddef[id=$refid]");
        $nameEl  = $doc->one("> compoundname",$classEl);
        $descEl  = $doc->one("> briefdescription",$classEl);
        $fileEl  = $doc->one("> location",$classEl);
        
        if(!$classEl || !$nameEl || !$descEl)
            return RESULT(cResult::Failed,"DOD_INVALID_CLASS_FILE");
        
        $att = array( "guid_value"=>$refid );
        
        if($fileEl){
            $filename = basename($doc->getAtt($fileEl,"file"));
            $att["filename"] = $filename;
        }

        if(!CatalogModule::createItem(
                $catalog,
                $classItem,
                $nameEl->nodeValue,
                $descEl->nodeValue,
                array("class","guid","source_file"),
                $att
            ))
                return false;
        
        //add methods...
        
        return RESULT_OK();
    }

    //
    public function functionFromDoxygen($doc)
    {
        //status de la base de données
        $attributes["bdd_status"] = "Indisponible, vérifiez la configuration de l'application et l'installation de votre SGBD";
        
        if($this->getDB($db_iface)){
            $attributes["bdd_status"] = $db_iface->getServiceProviderName();
            $attributes["bdd_status"] .= " ( ".$this->getCfgValue("database", "name")." @ ".$this->getCfgValue("database", "server_adr")." : ".$this->getCfgValue("database", "port")." )";
        }
        
        return parent::makeXMLView($filename,$attributes,$template_file);
    }
}

?>
