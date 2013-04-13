
/*---------------------------------------------------------------------------
 CATALOGUES
----------------------------------------------------------------------------

INSERT INTO CATALOG_ENTRY VALUES(1,'CODE_LIBRARY');*/

/*---------------------------------------------------------------------------
 CODE_LIBRARY
----------------------------------------------------------------------------
INSERT INTO CODE_LIBRARY VALUES(1,1,NULL,NULL,'test','Test librairie');*/


/*---------------------------------------------------------------------------
 CATEGORIES
----------------------------------------------------------------------------*/

INSERT INTO CATALOG_CATEGORY VALUES('function', 'Fonction', 'CODE_FUNCTION');
INSERT INTO CATALOG_CATEGORY VALUES('class', 'Classe', 'CODE_CLASS');
INSERT INTO CATALOG_CATEGORY VALUES('variable', 'Variable', 'CODE_VARIABLE');
INSERT INTO CATALOG_CATEGORY VALUES('return', 'Return', 'CODE_RETURN');
INSERT INTO CATALOG_CATEGORY VALUES('guid', 'GUID', 'GUID');
INSERT INTO CATALOG_CATEGORY VALUES('source_file', 'Fichier source', 'SOURCE_FILE');

/*---------------------------------------------------------------------------
 ITEMS
----------------------------------------------------------------------------

INSERT INTO CATALOG_ITEM VALUES(1,1,'puts', 'Put String function');
INSERT INTO CATALOG_ITEM VALUES(2,1,'toString', 'To String function');*/

/*---------------------------------------------------------------------------
 Assocation ITEM/CATEGORIES 
----------------------------------------------------------------------------*/

/* puts #1 
INSERT INTO CATALOG_ASSOCIER VALUES(1, 'function');
INSERT INTO CATALOG_ASSOCIER VALUES(1, 'return');
INSERT INTO CODE_FUNCTION (CATALOG_ITEM_ID, CODE_FUNCTION_ID, NAME, DESCRIPTION) VALUES(1, 1, 'puts', 'Put String function');
INSERT INTO CODE_RETURN   (CATALOG_ITEM_ID, CODE_RETURN_ID, DESCRIPTION)         VALUES(1, 1, 'Converted string value');
*/
/* toString #2 
INSERT INTO CATALOG_ASSOCIER VALUES(2, 'function');
INSERT INTO CATALOG_ASSOCIER VALUES(2, 'return');
INSERT INTO CODE_FUNCTION (CATALOG_ITEM_ID, CODE_FUNCTION_ID, NAME, DESCRIPTION) VALUES(2, 2,'toString', 'To String function');
INSERT INTO CODE_RETURN   (CATALOG_ITEM_ID, CODE_RETURN_ID, DESCRIPTION)         VALUES(2, 2, 'Converted string value');
*/