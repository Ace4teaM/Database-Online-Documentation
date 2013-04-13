<?php
/*
    ---------------------------------------------------------------------------------------------------------------------------------------
    (C)2012-2013 Thomas AUGUEY <contact@aceteam.org>
    ---------------------------------------------------------------------------------------------------------------------------------------
    This file is part of WebFrameWork.

    WebFrameWork is free software: you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation, either version 3 of the License, or
    (at your option) any later version.

    WebFrameWork is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with WebFrameWork.  If not, see <http://www.gnu.org/licenses/>.
    ---------------------------------------------------------------------------------------------------------------------------------------
*/

/**
 *  Webframework Module
 *  PHP Data-Model Implementation
*/


/**
* @author       developpement
*/
class CodeLibrary
{
   public function getId(){
      return $this->codeLibraryId;
  }
   public function setId($id){
      return $this->codeLibraryId = $id;
  }

    
    /**
    * @var      int
    */
    public $codeLibraryId;
    
    /**
    * @var      int
    */
    public $repositoryUrl;
    
    /**
    * @var      int
    */
    public $repositoryType;
    
    /**
    * @var      int
    */
    public $fileFilter;
    
    /**
    * @var      String
    */
    public $name;
    
    /**
    * @var      String
    */
    public $description;    

}

/*
   Code_Library Class manager
   
   This class is optimized for use with the Webfrmework project (www.webframework.fr)
*/
class CodeLibraryMgr
{
    /**
     * @brief Convert existing instance to XML element
     * @param $inst Entity instance (CodeLibrary)
     * @param $doc Parent document
     * @return New element node
     */
    public static function toXML(&$inst,$doc) {
        $node = $doc->createElement(strtolower("CodeLibrary"));
        
        $node->appendChild($doc->createTextElement("code_library_id",$inst->codeLibraryId));
        $node->appendChild($doc->createTextElement("repository_url",$inst->repositoryUrl));
        $node->appendChild($doc->createTextElement("repository_type",$inst->repositoryType));
        $node->appendChild($doc->createTextElement("file_filter",$inst->fileFilter));
        $node->appendChild($doc->createTextElement("name",$inst->name));
        $node->appendChild($doc->createTextElement("description",$inst->description));       

          
        return $node;
    }
    
    
    /*
      @brief Get entry list
      @param $list Array to receive new instances
      @param $cond SQL Select condition
      @param $db iDataBase derived instance
    */
    public static function getAll(&$list,$cond,$db=null){
       $list = array();
      
       //obtient la base de donnees courrante
       global $app;
       if(!$db && !$app->getDB($db))
         return false;
      
      //execute la requete
       $query = "SELECT * from Code_Library where $cond";
       if(!$db->execute($query,$result))
          return false;
       
      //extrait les instances
       $i=0;
       while( $result->seek($i,iDatabaseQuery::Origin) ){
        $inst = new CodeLibrary();
        CodeLibraryMgr::bindResult($inst,$result);
        array_push($list,$inst);
        $i++;
       }
       
       return RESULT_OK();
    }
    
    /*
      @brief Get single entry
      @param $inst CodeLibrary instance pointer to initialize
      @param $cond SQL Select condition
      @param $db iDataBase derived instance
    */
    public static function bindResult(&$inst,$result){
          $inst->codeLibraryId = $result->fetchValue("code_library_id");
          $inst->repositoryUrl = $result->fetchValue("repository_url");
          $inst->repositoryType = $result->fetchValue("repository_type");
          $inst->fileFilter = $result->fetchValue("file_filter");
          $inst->name = $result->fetchValue("name");
          $inst->description = $result->fetchValue("description");          

       return true;
    }
    
    /*
      @brief Get single entry
      @param $inst CodeLibrary instance pointer to initialize
      @param $cond SQL Select condition
      @param $db iDataBase derived instance
    */
    public static function get(&$inst,$cond,$db=null){
       //obtient la base de donnees courrante
       global $app;
       if(!$db && !$app->getDB($db))
         return false;
      
      //execute la requete
       $query = "SELECT * from Code_Library where $cond";
       if($db->execute($query,$result)){
            $inst = new CodeLibrary();
             if(!$result->rowCount())
                 return RESULT(cResult::Failed,iDatabaseQuery::EmptyResult);
          return CodeLibraryMgr::bindResult($inst,$result);
       }
       return false;
    }
    
    /*
      @brief Get single entry by id
      @param $inst CodeLibrary instance pointer to initialize
      @param $id Primary unique identifier of entry to retreive
      @param $db iDataBase derived instance
    */
    public static function getById(&$inst,$id,$db=null){
       //obtient la base de donnees courrante
       global $app;
       if(!$db && !$app->getDB($db))
         return false;
      
      //execute la requete
       $query = "SELECT * from Code_Library where Code_Library_id=".$db->parseValue($id);
       if($db->execute($query,$result)){
            $inst = new CodeLibrary();
             if(!$result->rowCount())
                 return RESULT(cResult::Failed,iDatabaseQuery::EmptyResult);
             self::bindResult($inst,$result);
          return true;
       }
       return false;
    }
    
   /*
      @brief Insert single entry by id
      @param $inst WriterDocument instance pointer to initialize
      @param $add_fields Array of columns names/columns values of additional fields
      @param $db iDataBase derived instance
    */
    public static function insert(&$inst,$add_fields=null,$db=null){
       //obtient la base de donnees courrante
       global $app;
       if(!$db && !$app->getDB($db))
         return false;
      
       //id initialise ?
       if(!isset($inst->codeLibraryId))
           return RESULT(cResult::Failed, cApplication::EntityMissingId);
      
      //execute la requete
       $query = "INSERT INTO Code_Library (";
       $query .= " code_library_id,";
       $query .= " repository_url,";
       $query .= " repository_type,";
       $query .= " file_filter,";
       $query .= " name,";
       $query .= " description,";
       if(is_array($add_fields))
           $query .= implode(',',array_keys($add_fields)).',';
       $query = substr($query,0,-1);//remove last ','
       $query .= ")";
       
       $query .= " VALUES(";
       $query .= $db->parseValue($inst->codeLibraryId).",";
       $query .= $db->parseValue($inst->repositoryUrl).",";
       $query .= $db->parseValue($inst->repositoryType).",";
       $query .= $db->parseValue($inst->fileFilter).",";
       $query .= $db->parseValue($inst->name).",";
       $query .= $db->parseValue($inst->description).",";
       if(is_array($add_fields))
           $query .= implode(',',$add_fields).',';
       $query = substr($query,0,-1);//remove last ','
       $query .= ")";
       
       if($db->execute($query,$result))
          return true;

       return false;
    }
    
   /*
      @brief Update single entry by id
      @param $inst WriterDocument instance pointer to initialize
      @param $db iDataBase derived instance
    */
    public static function update(&$inst,$db=null){
       //obtient la base de donnees courrante
       global $app;
       if(!$db && !$app->getDB($db))
         return false;
      
       //id initialise ?
       if(!isset($inst->codeLibraryId))
           return RESULT(cResult::Failed, cApplication::EntityMissingId);
      
      //execute la requete
       $query = "UPDATE Code_Library SET";
       $query .= " code_library_id =".$db->parseValue($inst->codeLibraryId).",";
       $query .= " repository_url =".$db->parseValue($inst->repositoryUrl).",";
       $query .= " repository_type =".$db->parseValue($inst->repositoryType).",";
       $query .= " file_filter =".$db->parseValue($inst->fileFilter).",";
       $query .= " name =".$db->parseValue($inst->name).",";
       $query .= " description =".$db->parseValue($inst->description).",";
       $query = substr($query,0,-1);//remove last ','
       $query .= " where Code_Library_id=".$db->parseValue($inst->codeLibraryId);
       if($db->execute($query,$result))
          return true;

       return false;
    }
    
   /** @brief Convert name to code */
    public static function nameToCode($name){
        for($i=strlen($name)-1;$i>=0;$i--){
            $c = substr($name, $i, 1);
            if(strpos("ABCDEFGHIJKLMNOPQRSTUVWXYZ",$c) !== FALSE){
                $name = substr_replace($name,($i?"_":"").strtolower($c), $i, 1);
            }
        }
        return $name;
    }
    
    /**
      @brief Get entry by id's relation table
      @param $inst CodeLibrary instance pointer to initialize
      @param $obj An another entry class object instance
      @param $db iDataBase derived instance
    */
    public static function getByRelation(&$inst,$obj,$db=null){
        $objectName = get_class($obj);
        $objectTableName  = CodeLibraryMgr::nameToCode($objectName);
        $objectIdName = lcfirst($objectName)."Id";
        
        /*print_r($objectName.", ");
        print_r($objectTableName.", ");
        print_r($objectIdName.", ");
        print_r($obj->$objectIdName);*/
        
        $select;
        if(is_string($obj->$objectIdName))
            $select = ("Code_Library_id = (select Code_Library_id from $objectTableName where ".$objectTableName."_id='".$obj->$objectIdName."')");
        else
            $select = ("Code_Library_id = (select Code_Library_id  from $objectTableName where ".$objectTableName."_id=".$obj->$objectIdName.")");

        return CodeLibraryMgr::get($inst,$select,$db);
    }

}

?>