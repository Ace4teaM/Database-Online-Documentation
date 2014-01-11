<?php
/*
    ---------------------------------------------------------------------------------------------------------------------------------------
    (C)2013 Thomas AUGUEY <contact@aceteam.org>
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

/*
 * Affiche la page d'accueil
 * Rôle : All
 * UC   : home
 */

class application_import_function_ctrl extends cApplicationCtrl
{
    // required fields
    public $fields    = array("filename","defid");
    
    // optional fields
    public $op_fields = null;

    // others data
    public $func; // FunctionObj 
    public $func_params; // FunctionParameter[] 
    
    function __construct()
    {
        // super call
        parent::__construct();
        
        // this, add cookies to entry fields 
        // $this->att = array_merge($this->att,$_COOKIE);
        
        // initalize...
        $this->func = new FunctionObj();
        $this->func_params = array();
    }
    
    function main(iApplication $app, $app_path, $p) {

        // ouvre le fichier
        $path = path($app->getCfgValue("path","import_path"), $p->filename);
        if(!file_exists($path))
            return RESULT(cResult::Failed,cApplication::ResourceNotFound,array("FILE"=>$path));

        $doc = new XMLDocument();
        if(!$doc->load($path))
            return RESULT(cResult::Failed,XMLDocument::loadFile,array("FILE"=>$path));

        // extrait les données
        $node = $doc->all("memberdef[kind='function']");
        foreach( $node as $k=>$n){
            if($n->getAttribute("id") != $p->defid)
                continue;
            //description
            if(NULL !== ($desc = $doc->one("briefdescription para",$n)))
                $this->func->desc = $desc->nodeValue;
            //nom
            if(NULL !== ($desc = $doc->one("name",$n)))
                $this->func->name = $desc->nodeValue;

            //return
            //if(NULL !== ($desc = $doc->one("name",$n)))
            //    $this->func->returnType = $desc->nodeValue;
            if(NULL !== ($desc = $doc->one("detaileddescription para simplesect[kind='return']",$n)))
                $this->func->returnDesc = $desc->nodeValue;

            //remark
            if(NULL !== ($desc = $doc->one("detaileddescription para simplesect[kind='remark']",$n)))
                $this->func->remark = $desc->nodeValue;


            //extrait les paramètres
            $paramsNodeList = $doc->all("detaileddescription para parameterlist[kind='param'] parameteritem",$n);
            foreach( $paramsNodeList as $paramKey=>$paramNode){
                $param = new FunctionParameter();
                $param->name = $doc->one("parameternamelist parametername",$paramNode)->nodeValue;
                $param->desc = $doc->one("parameterdescription para",$paramNode)->nodeValue;
                //$param->dataType = $doc->one("type",$paramNode)->nodeValue;
                $this->func_params[] = $param;
            }
            $paramsNodeList = $doc->all("param",$n);
            $i=0;
            foreach( $paramsNodeList as $paramKey=>$paramNode){
                $this->func_params[$i]->dataType = $doc->one("type",$paramNode)->nodeValue;
                $this->func_params[$i]->name = $doc->one("defname",$paramNode)->nodeValue;
                $i++;
            }
        }

        print_r($this->func);
        print_r($this->func_params);
        exit;
        return RESULT_OK();
    }
};

?>