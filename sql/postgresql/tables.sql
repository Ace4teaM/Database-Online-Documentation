/*==============================================================*/
/* Nom de SGBD :  PostgreSQL 8 (WFW)                            */
/* Date de création :  13/04/2013 18:18:07                      */
/*==============================================================*/


drop table if exists CATALOG_ASSOCIER  CASCADE;

drop table if exists CATALOG_CATEGORY  CASCADE;

drop table if exists CATALOG_ENTRY  CASCADE;

drop table if exists CATALOG_ITEM  CASCADE;

drop table if exists CODE_CLASS  CASCADE;

drop table if exists CODE_FUNCTION  CASCADE;

drop table if exists CODE_LIBRARY  CASCADE;

drop table if exists CODE_MEMBER  CASCADE;

drop table if exists CODE_PARAMETER  CASCADE;

drop table if exists CODE_PARAMETER_VALUE  CASCADE;

drop table if exists CODE_RETURN  CASCADE;

drop table if exists CODE_RETURN_VALUE  CASCADE;

drop table if exists "GROUP"  CASCADE;

drop table if exists GUID  CASCADE;

drop table if exists IMPLEMENTS  CASCADE;

drop table if exists LANGAGE  CASCADE;

drop table if exists PAGE  CASCADE;

drop table if exists SOURCE_FILE  CASCADE;

drop domain if exists CATALOG_ITEM_TYPE CASCADE;

drop domain if exists CATALOG_TYPE CASCADE;

/*==============================================================*/
/* Domaine : CATALOG_ITEM_TYPE                                  */
/*==============================================================*/
create domain CATALOG_ITEM_TYPE as VARCHAR(30);

comment on domain CATALOG_ITEM_TYPE is
'Ajouter ici les types d''items héritant de l''entité CATALOG_ITEM';

/*==============================================================*/
/* Domaine : CATALOG_TYPE                                       */
/*==============================================================*/
create domain CATALOG_TYPE as VARCHAR(30);

comment on domain CATALOG_TYPE is
'Ajoutez ici les types de catalogues héritant de l''entité CATALOG';

/*==============================================================*/
/* Table : CATALOG_ASSOCIER                                     */
/*==============================================================*/
create table CATALOG_ASSOCIER (
   CATALOG_ITEM_ID      INT4                 not null,
   CATALOG_CATEGORY_ID  VARCHAR(80)          not null,
   constraint PK_CATALOG_ASSOCIER primary key (CATALOG_ITEM_ID, CATALOG_CATEGORY_ID)
);

/*==============================================================*/
/* Table : CATALOG_CATEGORY                                     */
/*==============================================================*/
create table CATALOG_CATEGORY (
   CATALOG_CATEGORY_ID  VARCHAR(80)          not null,
   CATEGORY_DESC        VARCHAR(256)         not null,
   ITEM_TYPE            CATALOG_ITEM_TYPE    not null,
   constraint PK_CATALOG_CATEGORY primary key (CATALOG_CATEGORY_ID)
);

/*==============================================================*/
/* Table : CATALOG_ENTRY                                        */
/*==============================================================*/
create table CATALOG_ENTRY (
   CATALOG_ENTRY_ID     INT4                 not null,
   CATALOG_TYPE         CATALOG_TYPE         not null,
   constraint PK_CATALOG_ENTRY primary key (CATALOG_ENTRY_ID)
);

/*==============================================================*/
/* Table : CATALOG_ITEM                                         */
/*==============================================================*/
create table CATALOG_ITEM (
   CATALOG_ITEM_ID      INT4                 not null,
   CATALOG_ENTRY_ID     INT4                 not null,
   ITEM_TITLE           VARCHAR(80)          not null,
   ITEM_DESC            VARCHAR(256)         not null,
   CREATION_DATE        TIMESTAMP            not null,
   constraint PK_CATALOG_ITEM primary key (CATALOG_ITEM_ID)
);

/*==============================================================*/
/* Table : CODE_CLASS                                           */
/*==============================================================*/
create table CODE_CLASS (
   CATALOG_ITEM_ID      INT4                 not null,
   CODE_CLASS_ID        INT4                 not null,
   constraint PK_CODE_CLASS primary key (CATALOG_ITEM_ID, CODE_CLASS_ID)
);

/*==============================================================*/
/* Table : CODE_FUNCTION                                        */
/*==============================================================*/
create table CODE_FUNCTION (
   CATALOG_ITEM_ID      INT4                 not null,
   CODE_FUNCTION_ID     INT4                 not null,
   NAME                 VARCHAR(150)         not null,
   DESCRIPTION          VARCHAR(1024)        null,
   constraint PK_CODE_FUNCTION primary key (CATALOG_ITEM_ID, CODE_FUNCTION_ID)
);

/*==============================================================*/
/* Table : CODE_LIBRARY                                         */
/*==============================================================*/
create table CODE_LIBRARY (
   CATALOG_ENTRY_ID     INT4                 not null,
   CODE_LIBRARY_ID      INT4                 not null,
   REPOSITORY_URL       CHAR(10)             null,
   REPOSITORY_TYPE      CHAR(10)             null,
   FILE_FILTER          CHAR(10)             null,
   NAME                 VARCHAR(150)         null,
   DESCRIPTION          VARCHAR(1024)        null,
   constraint PK_CODE_LIBRARY primary key (CATALOG_ENTRY_ID, CODE_LIBRARY_ID)
);

/*==============================================================*/
/* Table : CODE_MEMBER                                          */
/*==============================================================*/
create table CODE_MEMBER (
   CATALOG_ITEM_ID      INT4                 not null,
   CODE_MEMBER_ID       INT4                 not null,
   CLASS_ITEM_ID        INT4                 not null,
   constraint PK_CODE_MEMBER primary key (CATALOG_ITEM_ID, CODE_MEMBER_ID)
);

/*==============================================================*/
/* Table : CODE_PARAMETER                                       */
/*==============================================================*/
create table CODE_PARAMETER (
   CATALOG_ITEM_ID      INT4                 not null,
   CODE_PARAMETER_ID    INT4                 not null,
   DATA_TYPE            VARCHAR(50)          not null,
   DESCRIPTION          VARCHAR(1024)        null,
   constraint PK_CODE_PARAMETER primary key (CATALOG_ITEM_ID, CODE_PARAMETER_ID)
);

/*==============================================================*/
/* Table : CODE_PARAMETER_VALUE                                 */
/*==============================================================*/
create table CODE_PARAMETER_VALUE (
   CODE_PARAMETER_VALUE_ID INT4                 not null,
   CATALOG_ITEM_ID      INT4                 not null,
   CODE_PARAMETER_ID    INT4                 not null,
   DESCRIPTION          VARCHAR(1024)        null,
   DATA_TYPE            VARCHAR(50)          not null,
   constraint PK_CODE_PARAMETER_VALUE primary key (CODE_PARAMETER_VALUE_ID)
);

/*==============================================================*/
/* Table : CODE_RETURN                                          */
/*==============================================================*/
create table CODE_RETURN (
   CATALOG_ITEM_ID      INT4                 not null,
   CODE_RETURN_ID       INT4                 not null,
   DESCRIPTION          VARCHAR(1024)        not null,
   constraint PK_CODE_RETURN primary key (CATALOG_ITEM_ID, CODE_RETURN_ID)
);

/*==============================================================*/
/* Table : CODE_RETURN_VALUE                                    */
/*==============================================================*/
create table CODE_RETURN_VALUE (
   CODE_RETURN_VALUE_ID INT4                 not null,
   CATALOG_ITEM_ID      INT4                 not null,
   CODE_RETURN_ID       INT4                 not null,
   DATA_TYPE            VARCHAR(50)          not null,
   DESCRIPTION          VARCHAR(1024)        null,
   constraint PK_CODE_RETURN_VALUE primary key (CODE_RETURN_VALUE_ID)
);

/*==============================================================*/
/* Table : "GROUP"                                              */
/*==============================================================*/
create table "GROUP" (
   CATALOG_ITEM_ID      INT4                 not null,
   GROUP_ID             INT4                 not null,
   constraint PK_GROUP primary key (CATALOG_ITEM_ID, GROUP_ID)
);

/*==============================================================*/
/* Table : GUID                                                 */
/*==============================================================*/
create table GUID (
   CATALOG_ITEM_ID      INT4                 not null,
   GUID_ID              INT4                 not null,
   GUID_VALUE           VARCHAR(260)         not null,
   constraint PK_GUID primary key (CATALOG_ITEM_ID, GUID_ID)
);

/*==============================================================*/
/* Table : IMPLEMENTS                                           */
/*==============================================================*/
create table IMPLEMENTS (
   CATALOG_ITEM_ID      INT4                 not null,
   CAT_CATALOG_ITEM_ID  INT4                 not null,
   constraint PK_IMPLEMENTS primary key (CATALOG_ITEM_ID, CAT_CATALOG_ITEM_ID)
);

/*==============================================================*/
/* Table : LANGAGE                                              */
/*==============================================================*/
create table LANGAGE (
   CATALOG_ITEM_ID      INT4                 not null,
   LANGAGE_ID           INT4                 not null,
   LANGAGE_CODE         VARCHAR(4)           not null,
   LANGAGE_NAME         VARCHAR(80)          not null,
   constraint PK_LANGAGE primary key (CATALOG_ITEM_ID, LANGAGE_ID)
);

/*==============================================================*/
/* Table : PAGE                                                 */
/*==============================================================*/
create table PAGE (
   CATALOG_ITEM_ID      INT4                 not null,
   PAGE_ID              INT4                 not null,
   CONTENT_TYPE         VARCHAR(120)         not null,
   CONTENT              TEXT                 not null,
   constraint PK_PAGE primary key (CATALOG_ITEM_ID, PAGE_ID)
);

/*==============================================================*/
/* Table : SOURCE_FILE                                          */
/*==============================================================*/
create table SOURCE_FILE (
   CATALOG_ITEM_ID      INT4                 not null,
   SOURCE_FILE_ID       INT4                 not null,
   FILENAME             VARCHAR(260)         not null,
   constraint PK_SOURCE_FILE primary key (CATALOG_ITEM_ID, SOURCE_FILE_ID)
);

alter table CATALOG_ASSOCIER
   add constraint FK_CATALOG_ASSOCIER foreign key (CATALOG_CATEGORY_ID)
      references CATALOG_CATEGORY (CATALOG_CATEGORY_ID)
      on delete restrict on update restrict;

alter table CATALOG_ASSOCIER
   add constraint FK_CATALOG_ASSOCIER2 foreign key (CATALOG_ITEM_ID)
      references CATALOG_ITEM (CATALOG_ITEM_ID)
      on delete restrict on update restrict;

alter table CATALOG_ITEM
   add constraint FK_CATALOG_ATTACHER foreign key (CATALOG_ENTRY_ID)
      references CATALOG_ENTRY (CATALOG_ENTRY_ID)
      on delete restrict on update restrict;

alter table CODE_CLASS
   add constraint FK_CATALOG_ITEM_EXTENDS9 foreign key (CATALOG_ITEM_ID)
      references CATALOG_ITEM (CATALOG_ITEM_ID)
      on delete restrict on update restrict;

alter table CODE_FUNCTION
   add constraint FK_CATALOG_ITEM_EXTENDS2 foreign key (CATALOG_ITEM_ID)
      references CATALOG_ITEM (CATALOG_ITEM_ID)
      on delete restrict on update restrict;

alter table CODE_LIBRARY
   add constraint FK_CATALO_ENTRY_EXTENDS foreign key (CATALOG_ENTRY_ID)
      references CATALOG_ENTRY (CATALOG_ENTRY_ID)
      on delete restrict on update restrict;

alter table CODE_MEMBER
   add constraint FK_CATALOG_ITEM_EXTENDS5 foreign key (CATALOG_ITEM_ID)
      references CATALOG_ITEM (CATALOG_ITEM_ID)
      on delete restrict on update restrict;

alter table CODE_PARAMETER
   add constraint FK_CATALOG_ITEM_EXTENDS3 foreign key (CATALOG_ITEM_ID)
      references CATALOG_ITEM (CATALOG_ITEM_ID)
      on delete restrict on update restrict;

alter table CODE_PARAMETER_VALUE
   add constraint FK_ASSOCIATION_5 foreign key (CATALOG_ITEM_ID, CODE_PARAMETER_ID)
      references CODE_PARAMETER (CATALOG_ITEM_ID, CODE_PARAMETER_ID)
      on delete restrict on update restrict;

alter table CODE_RETURN
   add constraint FK_CATALOG_ITEM_EXTENDS foreign key (CATALOG_ITEM_ID)
      references CATALOG_ITEM (CATALOG_ITEM_ID)
      on delete restrict on update restrict;

alter table CODE_RETURN_VALUE
   add constraint FK_ASSOCIATION_4 foreign key (CATALOG_ITEM_ID, CODE_RETURN_ID)
      references CODE_RETURN (CATALOG_ITEM_ID, CODE_RETURN_ID)
      on delete restrict on update restrict;

alter table "GROUP"
   add constraint FK_CATALOG_ITEM_EXTENDS6 foreign key (CATALOG_ITEM_ID)
      references CATALOG_ITEM (CATALOG_ITEM_ID)
      on delete restrict on update restrict;

alter table GUID
   add constraint FK_CATALOG_ITEM_EXTENDS8 foreign key (CATALOG_ITEM_ID)
      references CATALOG_ITEM (CATALOG_ITEM_ID)
      on delete restrict on update restrict;

alter table IMPLEMENTS
   add constraint FK_IMPLEMENTS foreign key (CAT_CATALOG_ITEM_ID)
      references CATALOG_ITEM (CATALOG_ITEM_ID)
      on delete restrict on update restrict;

alter table IMPLEMENTS
   add constraint FK_IMPLEMENTS2 foreign key (CATALOG_ITEM_ID)
      references CATALOG_ITEM (CATALOG_ITEM_ID)
      on delete restrict on update restrict;

alter table LANGAGE
   add constraint FK_CATALOG_ITEM_EXTENDS7 foreign key (CATALOG_ITEM_ID)
      references CATALOG_ITEM (CATALOG_ITEM_ID)
      on delete restrict on update restrict;

alter table PAGE
   add constraint FK_CATALOG_ITEM_EXTENDS4 foreign key (CATALOG_ITEM_ID)
      references CATALOG_ITEM (CATALOG_ITEM_ID)
      on delete restrict on update restrict;

alter table SOURCE_FILE
   add constraint FK_CATALOG_ITEM_EXTENDS10 foreign key (CATALOG_ITEM_ID)
      references CATALOG_ITEM (CATALOG_ITEM_ID)
      on delete restrict on update restrict;

