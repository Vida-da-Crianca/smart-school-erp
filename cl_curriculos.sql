/*
 Navicat Premium Data Transfer

 Source Server         : localhost
 Source Server Type    : MySQL
 Source Server Version : 50736
 Source Host           : localhost:3306
 Source Schema         : schol

 Target Server Type    : MySQL
 Target Server Version : 50736
 File Encoding         : 65001

 Date: 25/01/2022 02:34:41
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for cl_curriculos
-- ----------------------------
DROP TABLE IF EXISTS `cl_curriculos`;
CREATE TABLE `cl_curriculos`  (
  `id` int(15) NOT NULL,
  `nome` text CHARACTER SET utf8 COLLATE utf8_general_ci NULL,
  `email` text CHARACTER SET utf8 COLLATE utf8_general_ci NULL,
  `cep` text CHARACTER SET utf8 COLLATE utf8_general_ci NULL,
  `endereco` text CHARACTER SET utf8 COLLATE utf8_general_ci NULL,
  `funcao` text CHARACTER SET utf8 COLLATE utf8_general_ci NULL,
  `cargo` text CHARACTER SET utf8 COLLATE utf8_general_ci NULL,
  `departamento` text CHARACTER SET utf8 COLLATE utf8_general_ci NULL,
  `nome_pai` text CHARACTER SET utf8 COLLATE utf8_general_ci NULL,
  `nome_mae` text CHARACTER SET utf8 COLLATE utf8_general_ci NULL,
  `sexo` text CHARACTER SET utf8 COLLATE utf8_general_ci NULL,
  `data_nascimento` text CHARACTER SET utf8 COLLATE utf8_general_ci NULL,
  `telefone` text CHARACTER SET utf8 COLLATE utf8_general_ci NULL,
  `estado_civil` text CHARACTER SET utf8 COLLATE utf8_general_ci NULL,
  `data_envio` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `facebook` text CHARACTER SET utf8 COLLATE utf8_general_ci NULL,
  `twitter` text CHARACTER SET utf8 COLLATE utf8_general_ci NULL,
  `instagram` text CHARACTER SET utf8 COLLATE utf8_general_ci NULL,
  `linkedin` text CHARACTER SET utf8 COLLATE utf8_general_ci NULL,
  `work_exp` text CHARACTER SET utf8 COLLATE utf8_general_ci NULL,
  `cursos` text CHARACTER SET utf8 COLLATE utf8_general_ci NULL,
  `outros` text CHARACTER SET utf8 COLLATE utf8_general_ci NULL,
  `numero` text CHARACTER SET utf8 COLLATE utf8_general_ci NULL,
  `telefone_emergencia` text CHARACTER SET utf8 COLLATE utf8_general_ci NULL,
  `contrato_inicio` text CHARACTER SET utf8 COLLATE utf8_general_ci NULL,
  `endereco_permanente` text CHARACTER SET utf8 COLLATE utf8_general_ci NULL,
  `foto` text CHARACTER SET utf8 COLLATE utf8_general_ci NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = MyISAM CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

SET FOREIGN_KEY_CHECKS = 1;
