/*==============================================================*/
/* DBMS name:      MySQL 5.0                                    */
/* Created on:     11/8/2024 1:36:54 PM                         */
/*==============================================================*/

`e-librarykkg`
drop table if exists ADMIN;

drop table if exists DOKUMENTASI;

drop table if exists KATEGORI;

drop table if exists STAFF_KKG;

drop table if exists TAHUN;

/*==============================================================*/
/* Table: ADMIN                                                 */
/*==============================================================*/
create table ADMIN
(
   ADMIN_ID             int not null,
   DOKUMENTASI_ID       varchar(15),
   NAMA                 varchar(50),
   EMAIL                varchar(50),
   PASSWORD             varchar(50),
   primary key (ADMIN_ID)
);

/*==============================================================*/
/* Table: DOKUMENTASI                                           */
/*==============================================================*/
create table DOKUMENTASI
(
   DOKUMENTASI_ID       varchar(15) not null,
   JUDUL                varchar(255),
   DESKRIPSI            text,
   TANGGAL_DOKUMEN      date,
   FILE_PATH            varchar(50),
   URL_VIDEO            varchar(50),
   FORMAT_FILE          varchar(35),
   JENIS_DOKUMEN        varchar(15),
   KATEGORI_ID          int,
   TAHUN_ID             int,
   ADMIN_ID             int,
   primary key (DOKUMENTASI_ID)
);

/*==============================================================*/
/* Table: KATEGORI                                              */
/*==============================================================*/
create table KATEGORI
(
   KATEGORI_ID          int not null,
   TAHUN_ID             int,
   NAMA_KATEGORI        varchar(50),
   primary key (KATEGORI_ID)
);

/*==============================================================*/
/* Table: STAFF_KKG                                             */
/*==============================================================*/
create table STAFF_KKG
(
   STAFF_ID             int not null,
   DOKUMENTASI_ID       varchar(15),
   NAMA                 varchar(50),
   EMAIL                varchar(50),
   primary key (STAFF_ID)
);

/*==============================================================*/
/* Table: TAHUN                                                 */
/*==============================================================*/
create table TAHUN
(
   TAHUN_ID             int not null,
   TAHUN                datetime,
   primary key (TAHUN_ID)
);

alter table ADMIN add constraint FK_MENGELOLA foreign key (DOKUMENTASI_ID)
      references DOKUMENTASI (DOKUMENTASI_ID) on delete restrict on update restrict;

alter table DOKUMENTASI add constraint FK_TERBAGI foreign key (KATEGORI_ID)
      references KATEGORI (KATEGORI_ID) on delete restrict on update restrict;

alter table KATEGORI add constraint FK_MEMUAT foreign key (TAHUN_ID)
      references TAHUN (TAHUN_ID) on delete restrict on update restrict;

alter table STAFF_KKG add constraint FK_MELIHAT foreign key (DOKUMENTASI_ID)
      references DOKUMENTASI (DOKUMENTASI_ID) on delete restrict on update restrict;

