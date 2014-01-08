/*==============================================================*/
/* Nom de SGBD :  PostgreSQL 8 (WFW)                            */
/* Date de création :  08/01/2014 20:10:45                      */
/*==============================================================*/


drop table if exists CLASS_OBJ  CASCADE;

drop table if exists EXTENDS  CASCADE;

drop table if exists FUNCTION_OBJ  CASCADE;

drop table if exists FUNCTION_PARAMETER  CASCADE;

drop table if exists IMPLEMENT  CASCADE;

drop table if exists LIBRARY  CASCADE;

drop table if exists MEMBER  CASCADE;

drop table if exists METHOD  CASCADE;

drop table if exists METHOD_PARAMETER  CASCADE;

drop table if exists STRUCT_OBJ  CASCADE;

/*==============================================================*/
/* Table : CLASS_OBJ                                            */
/*==============================================================*/
create table CLASS_OBJ (
   CLASS_OBJ_ID         INT4                 not null,
   LIBRARY_ID           INT4                 not null,
   NAME                 VARCHAR(128)         not null,
   "DESC"               VARCHAR(1024)        null,
   constraint PK_CLASS_OBJ primary key (CLASS_OBJ_ID)
);

/*==============================================================*/
/* Table : EXTENDS                                              */
/*==============================================================*/
create table EXTENDS (
   CLASS_OBJ_ID         INT4                 not null,
   CLA_CLASS_OBJ_ID     INT4                 not null,
   constraint PK_EXTENDS primary key (CLASS_OBJ_ID, CLA_CLASS_OBJ_ID)
);

/*==============================================================*/
/* Table : FUNCTION_OBJ                                         */
/*==============================================================*/
create table FUNCTION_OBJ (
   FUNCTION_OBJ_ID      INT4                 not null,
   LIBRARY_ID           INT4                 not null,
   NAME                 VARCHAR(128)         not null,
   "DESC"               VARCHAR(1024)        null,
   RETURN_TYPE          VARCHAR(128)         not null,
   constraint PK_FUNCTION_OBJ primary key (FUNCTION_OBJ_ID)
);

/*==============================================================*/
/* Table : FUNCTION_PARAMETER                                   */
/*==============================================================*/
create table FUNCTION_PARAMETER (
   FUNCTION_PARAMETER_ID INT4                 not null,
   FUNCTION_OBJ_ID      INT4                 not null,
   NAME                 VARCHAR(128)         not null,
   "DESC"               VARCHAR(1024)        null,
   DATA_TYPE            VARCHAR(128)         null,
   constraint PK_FUNCTION_PARAMETER primary key (FUNCTION_PARAMETER_ID)
);

/*==============================================================*/
/* Table : IMPLEMENT                                            */
/*==============================================================*/
create table IMPLEMENT (
   CLASS_OBJ_ID         INT4                 not null,
   CLA_CLASS_OBJ_ID     INT4                 not null,
   constraint PK_IMPLEMENT primary key (CLASS_OBJ_ID, CLA_CLASS_OBJ_ID)
);

/*==============================================================*/
/* Table : LIBRARY                                              */
/*==============================================================*/
create table LIBRARY (
   LIBRARY_ID           INT4                 not null,
   NAME                 VARCHAR(128)         not null,
   "DESC"               VARCHAR(1024)        null,
   constraint PK_LIBRARY primary key (LIBRARY_ID)
);

/*==============================================================*/
/* Table : MEMBER                                               */
/*==============================================================*/
create table MEMBER (
   MEMBER_ID            INT4                 not null,
   STRUCT_OBJ_ID        INT4                 not null,
   NAME                 VARCHAR(128)         not null,
   "DESC"               VARCHAR(1024)        null,
   DATA_TYPE            VARCHAR(128)         null,
   constraint PK_MEMBER primary key (MEMBER_ID)
);

/*==============================================================*/
/* Table : METHOD                                               */
/*==============================================================*/
create table METHOD (
   METHOD_ID            INT4                 not null,
   CLASS_OBJ_ID         INT4                 not null,
   NAME                 VARCHAR(128)         not null,
   "DESC"               VARCHAR(1024)        null,
   RETURN_TYPE          VARCHAR(128)         not null,
   constraint PK_METHOD primary key (METHOD_ID)
);

/*==============================================================*/
/* Table : METHOD_PARAMETER                                     */
/*==============================================================*/
create table METHOD_PARAMETER (
   METHOD_PARAMETER_ID  INT4                 not null,
   METHOD_ID            INT4                 not null,
   NAME                 VARCHAR(128)         not null,
   "DESC"               VARCHAR(1024)        null,
   DATA_TYPE            VARCHAR(128)         not null,
   constraint PK_METHOD_PARAMETER primary key (METHOD_PARAMETER_ID)
);

/*==============================================================*/
/* Table : STRUCT_OBJ                                           */
/*==============================================================*/
create table STRUCT_OBJ (
   STRUCT_OBJ_ID        INT4                 not null,
   LIBRARY_ID           INT4                 not null,
   NAME                 VARCHAR(128)         not null,
   "DESC"               VARCHAR(1024)        null,
   constraint PK_STRUCT_OBJ primary key (STRUCT_OBJ_ID)
);

alter table CLASS_OBJ
   add constraint FK_ASSOCIATION_7 foreign key (LIBRARY_ID)
      references LIBRARY (LIBRARY_ID)
      on delete restrict on update restrict;

alter table EXTENDS
   add constraint FK_EXTENDS foreign key (CLA_CLASS_OBJ_ID)
      references CLASS_OBJ (CLASS_OBJ_ID)
      on delete restrict on update restrict;

alter table EXTENDS
   add constraint FK_EXTENDS2 foreign key (CLASS_OBJ_ID)
      references CLASS_OBJ (CLASS_OBJ_ID)
      on delete restrict on update restrict;

alter table FUNCTION_OBJ
   add constraint FK_ASSOCIATION_2 foreign key (LIBRARY_ID)
      references LIBRARY (LIBRARY_ID)
      on delete restrict on update restrict;

alter table FUNCTION_PARAMETER
   add constraint FK_ASSOCIATION_1 foreign key (FUNCTION_OBJ_ID)
      references FUNCTION_OBJ (FUNCTION_OBJ_ID)
      on delete restrict on update restrict;

alter table IMPLEMENT
   add constraint FK_IMPLEMENT foreign key (CLA_CLASS_OBJ_ID)
      references CLASS_OBJ (CLASS_OBJ_ID)
      on delete restrict on update restrict;

alter table IMPLEMENT
   add constraint FK_IMPLEMENT2 foreign key (CLASS_OBJ_ID)
      references CLASS_OBJ (CLASS_OBJ_ID)
      on delete restrict on update restrict;

alter table MEMBER
   add constraint FK_ASSOCIATION_4 foreign key (STRUCT_OBJ_ID)
      references STRUCT_OBJ (STRUCT_OBJ_ID)
      on delete restrict on update restrict;

alter table METHOD
   add constraint FK_ASSOCIATION_6 foreign key (CLASS_OBJ_ID)
      references CLASS_OBJ (CLASS_OBJ_ID)
      on delete restrict on update restrict;

alter table METHOD_PARAMETER
   add constraint FK_ASSOCIATION_5 foreign key (METHOD_ID)
      references METHOD (METHOD_ID)
      on delete restrict on update restrict;

alter table STRUCT_OBJ
   add constraint FK_ASSOCIATION_3 foreign key (LIBRARY_ID)
      references LIBRARY (LIBRARY_ID)
      on delete restrict on update restrict;

