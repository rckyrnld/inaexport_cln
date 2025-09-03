/*
 Navicat Premium Data Transfer

 Source Server         : Maxx-JKT
 Source Server Type    : PostgreSQL
 Source Server Version : 100010
 Source Host           : 115.124.73.253:5432
 Source Catalog        : kemendag
 Source Schema         : public

 Target Server Type    : PostgreSQL
 Target Server Version : 100010
 File Encoding         : 65001

 Date: 15/11/2019 08:33:13
*/


-- ----------------------------
-- Table structure for itdp_contact_imp
-- ----------------------------
DROP TABLE IF EXISTS "public"."itdp_contact_imp";
CREATE TABLE "public"."itdp_contact_imp" (
  "id" int4 NOT NULL DEFAULT nextval('itdp_contact_importir_id_seq'::regclass),
  "name" varchar(255) COLLATE "pg_catalog"."default",
  "email" varchar(255) COLLATE "pg_catalog"."default",
  "phone" varchar(255) COLLATE "pg_catalog"."default",
  "id_user" int4
)
;

-- ----------------------------
-- Records of itdp_contact_imp
-- ----------------------------
INSERT INTO "public"."itdp_contact_imp" VALUES (1, 'Ilyas China', 'china@gmail.com', '121212121', 40000);

-- ----------------------------
-- Primary Key structure for table itdp_contact_imp
-- ----------------------------
ALTER TABLE "public"."itdp_contact_imp" ADD CONSTRAINT "itdp_contact_importir_pkey" PRIMARY KEY ("id");
