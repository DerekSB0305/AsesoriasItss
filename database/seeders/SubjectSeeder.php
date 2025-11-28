<?php

namespace Database\Seeders;

use App\Models\Subject;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SubjectSeeder extends Seeder
{
    public function run()
    {
        DB::table('subjects')->insert([

            // ================================
            //  CARRERA 1 — INGENIERÍA INFORMÁTICA
            //  PERIODO: IINF-2010-220
            // ================================
            [
                'name'       => 'Fundamentos de Programación',
                'type'       => 'AEF-1032',
                'period'     => 'IINF-2010-220',
                'career_id'  => 1,
            ],
            [
                'name'       => 'Programación Orientada a Objetos',
                'type'       => 'AEF-1033',
                'period'     => 'IINF-2010-220',
                'career_id'  => 1,
            ],
            [
                'name'       => 'Estructura de Datos',
                'type'       => 'AEF-1044',
                'period'     => 'IINF-2010-220',
                'career_id'  => 1,
            ],
            [
                'name'       => 'Taller de Sistemas Operativos',
                'type'       => 'AEF-1135',
                'period'     => 'IINF-2010-220',
                'career_id'  => 1,
            ],
            [
                'name'       => 'Matemáticas Discretas',
                'type'       => 'AEF-1090',
                'period'     => 'IINF-2010-220',
                'career_id'  => 1,
            ],
            [
                'name'       => 'Álgebra Lineal',
                'type'       => 'AEF-1050',
                'period'     => 'IINF-2010-220',
                'career_id'  => 1,
            ],
            [
                'name'       => 'Cálculo Diferencial',
                'type'       => 'AEF-1010',
                'period'     => 'IINF-2010-220',
                'career_id'  => 1,
            ],
            [
                'name'       => 'Cálculo Integral',
                'type'       => 'AEF-1011',
                'period'     => 'IINF-2010-220',
                'career_id'  => 1,
            ],
            [
                'name'       => 'Probabilidad y Estadística',
                'type'       => 'AEF-1109',
                'period'     => 'IINF-2010-220',
                'career_id'  => 1,
            ],
            [
                'name'       => 'Ingeniería de Software',
                'type'       => 'AEF-1191',
                'period'     => 'IINF-2010-220',
                'career_id'  => 1,
            ],
            [
                'name'       => 'Bases de Datos',
                'type'       => 'AEF-1136',
                'period'     => 'IINF-2010-220',
                'career_id'  => 1,
            ],
            [
                'name'       => 'Fundamentos de Redes',
                'type'       => 'AEF-1221',
                'period'     => 'IINF-2010-220',
                'career_id'  => 1,
            ],
            [
                'name'       => 'Administración de Servidores',
                'type'       => 'AEF-1215',
                'period'     => 'IINF-2010-220',
                'career_id'  => 1,
            ],
            [
                'name'       => 'Programación Web',
                'type'       => 'AEF-1201',
                'period'     => 'IINF-2010-220',
                'career_id'  => 1,
            ],
            [
                'name'       => 'Programación Lógica y Funcional',
                'type'       => 'AEF-1255',
                'period'     => 'IINF-2010-220',
                'career_id'  => 1,
            ],

            // ===================================================
            //  CARRERA 2 — INGENIERÍA BIOQUÍMICA
            //  PERIODO: IBQA-2010-207
            // ===================================================
            [
                'name'       => 'Biología Celular',
                'type'       => 'AEB-1021',
                'period'     => 'IBQA-2010-207',
                'career_id'  => 2,
            ],
            [
                'name'       => 'Química General',
                'type'       => 'AEB-1023',
                'period'     => 'IBQA-2010-207',
                'career_id'  => 2,
            ],
            [
                'name'       => 'Balance de Materia y Energía',
                'type'       => 'AEB-1150',
                'period'     => 'IBQA-2010-207',
                'career_id'  => 2,
            ],
            [
                'name'       => 'Microbiología Industrial',
                'type'       => 'AEB-1120',
                'period'     => 'IBQA-2010-207',
                'career_id'  => 2,
            ],
            [
                'name'       => 'Bioquímica',
                'type'       => 'AEB-1027',
                'period'     => 'IBQA-2010-207',
                'career_id'  => 2,
            ],
            [
                'name'       => 'Fisicoquímica',
                'type'       => 'AEB-1158',
                'period'     => 'IBQA-2010-207',
                'career_id'  => 2,
            ],
            [
                'name'       => 'Operaciones Unitarias I',
                'type'       => 'AEB-1142',
                'period'     => 'IBQA-2010-207',
                'career_id'  => 2,
            ],
            [
                'name'       => 'Operaciones Unitarias II',
                'type'       => 'AEB-1143',
                'period'     => 'IBQA-2010-207',
                'career_id'  => 2,
            ],
            [
                'name'       => 'Biotecnología',
                'type'       => 'AEB-1102',
                'period'     => 'IBQA-2010-207',
                'career_id'  => 2,
            ],
            [
                'name'       => 'Termodinámica',
                'type'       => 'AEB-1160',
                'period'     => 'IBQA-2010-207',
                'career_id'  => 2,
            ],

            // ================================
            //  CARRERA 3 — INGENIERÍA INDUSTRIAL
            //  PERIODO: IIND-2010-227
            // ================================
            [
                'name'      => 'Administración de Operaciones',
                'type'      => 'AEI-1131',
                'period'    => 'IIND-2010-227',
                'career_id' => 3,
            ],
            [
                'name'      => 'Administración de la Calidad',
                'type'      => 'AEI-1130',
                'period'    => 'IIND-2010-227',
                'career_id' => 3,
            ],
            [
                'name'      => 'Ingeniería Económica',
                'type'      => 'AEI-1201',
                'period'    => 'IIND-2010-227',
                'career_id' => 3,
            ],
            [
                'name'      => 'Ergonomía',
                'type'      => 'AEI-1157',
                'period'    => 'IIND-2010-227',
                'career_id' => 3,
            ],
            [
                'name'      => 'Logística',
                'type'      => 'AEI-1222',
                'period'    => 'IIND-2010-227',
                'career_id' => 3,
            ],
            [
                'name'      => 'Sistemas de Manufactura',
                'type'      => 'AEI-1311',
                'period'    => 'IIND-2010-227',
                'career_id' => 3,
            ],
            [
                'name'      => 'Control Estadístico de Procesos',
                'type'      => 'AEI-1114',
                'period'    => 'IIND-2010-227',
                'career_id' => 3,
            ],
            [
                'name'      => 'Metrología y Normalización',
                'type'      => 'AEI-1210',
                'period'    => 'IIND-2010-227',
                'career_id' => 3,
            ],
            [
                'name'      => 'Planeación y Control de la Producción',
                'type'      => 'AEI-1250',
                'period'    => 'IIND-2010-227',
                'career_id' => 3,
            ],
            [
                'name'      => 'Estudio del Trabajo I',
                'type'      => 'AEI-1150',
                'period'    => 'IIND-2010-227',
                'career_id' => 3,
            ],
            [
                'name'      => 'Estudio del Trabajo II',
                'type'      => 'AEI-1151',
                'period'    => 'IIND-2010-227',
                'career_id' => 3,
            ],
            [
                'name'      => 'Higiene y Seguridad Industrial',
                'type'      => 'AEI-1199',
                'period'    => 'IIND-2010-227',
                'career_id' => 3,
            ],


            // ================================
            //  CARRERA 4 — INGENIERÍA AGRONOMÍA
            //  PERIODO: IAGR-2010-214
            // ================================
            [
                'name'      => 'Edafología',
                'type'      => 'AEA-1105',
                'period'    => 'IAGR-2010-214',
                'career_id' => 4,
            ],
            [
                'name'      => 'Fisiología Vegetal',
                'type'      => 'AEA-1150',
                'period'    => 'IAGR-2010-214',
                'career_id' => 4,
            ],
            [
                'name'      => 'Manejo de Cultivos',
                'type'      => 'AEA-1243',
                'period'    => 'IAGR-2010-214',
                'career_id' => 4,
            ],
            [
                'name'      => 'Agrometeorología',
                'type'      => 'AEA-1025',
                'period'    => 'IAGR-2010-214',
                'career_id' => 4,
            ],
            [
                'name'      => 'Irrigación',
                'type'      => 'AEA-1198',
                'period'    => 'IAGR-2010-214',
                'career_id' => 4,
            ],
            [
                'name'      => 'Topografía Agrícola',
                'type'      => 'AEA-1288',
                'period'    => 'IAGR-2010-214',
                'career_id' => 4,
            ],
            [
                'name'      => 'Entomología Agrícola',
                'type'      => 'AEA-1132',
                'period'    => 'IAGR-2010-214',
                'career_id' => 4,
            ],
            [
                'name'      => 'Fitopatología',
                'type'      => 'AEA-1157',
                'period'    => 'IAGR-2010-214',
                'career_id' => 4,
            ],
            [
                'name'      => 'Manejo de Suelos',
                'type'      => 'AEA-1246',
                'period'    => 'IAGR-2010-214',
                'career_id' => 4,
            ],
            [
                'name'      => 'Producción de Forrajes',
                'type'      => 'AEA-1265',
                'period'    => 'IAGR-2010-214',
                'career_id' => 4,
            ],
            [
                'name'      => 'Recursos Fitogenéticos',
                'type'      => 'AEA-1281',
                'period'    => 'IAGR-2010-214',
                'career_id' => 4,
            ],


            // ==========================================
            //  MATERIAS COMPARTIDAS ENTRE INGENIERÍAS 
            //  (career_id = null)
            // ==========================================
            [
                'name'      => 'Química',
                'type'      => 'AEG-1055',
                'period'    => 'GEN-2010',
                'career_id' => null,
            ],
            [
                'name'      => 'Cálculo Diferencial',
                'type'      => 'AEG-1010',
                'period'    => 'GEN-2010',
                'career_id' => null,
            ],
            [
                'name'      => 'Cálculo Integral',
                'type'      => 'AEG-1011',
                'period'    => 'GEN-2010',
                'career_id' => null,
            ],
            [
                'name'      => 'Física',
                'type'      => 'AEG-1060',
                'period'    => 'GEN-2010',
                'career_id' => null,
            ],
            [
                'name'      => 'Probabilidad y Estadística',
                'type'      => 'AEG-1109',
                'period'    => 'GEN-2010',
                'career_id' => null,
            ],
            [
                'name'      => 'Álgebra Lineal',
                'type'      => 'AEG-1050',
                'period'    => 'GEN-2010',
                'career_id' => null,
            ],
            [
                'name'      => 'Ecología',
                'type'      => 'AEG-1092',
                'period'    => 'GEN-2010',
                'career_id' => null,
            ],
            [
                'name'      => 'Desarrollo Sustentable',
                'type'      => 'AEG-1078',
                'period'    => 'GEN-2010',
                'career_id' => null,
            ],

            // ================================
            //  CARRERA 5 — ADMINISTRACIÓN
            //  PERIODO: IADM-2010-213
            // ================================
            [
                'name'      => 'Fundamentos de Administración',
                'type'      => 'AEA-1001',
                'period'    => 'IADM-2010-213',
                'career_id' => 5,
            ],
            [
                'name'      => 'Contabilidad Financiera',
                'type'      => 'AEA-1048',
                'period'    => 'IADM-2010-213',
                'career_id' => 5,
            ],
            [
                'name'      => 'Contabilidad de Costos',
                'type'      => 'AEA-1049',
                'period'    => 'IADM-2010-213',
                'career_id' => 5,
            ],
            [
                'name'      => 'Administración de Recursos Humanos',
                'type'      => 'AEA-1030',
                'period'    => 'IADM-2010-213',
                'career_id' => 5,
            ],
            [
                'name'      => 'Administración Estratégica',
                'type'      => 'AEA-1024',
                'period'    => 'IADM-2010-213',
                'career_id' => 5,
            ],
            [
                'name'      => 'Mercadotecnia',
                'type'      => 'AEA-1184',
                'period'    => 'IADM-2010-213',
                'career_id' => 5,
            ],
            [
                'name'      => 'Economía Empresarial',
                'type'      => 'AEA-1102',
                'period'    => 'IADM-2010-213',
                'career_id' => 5,
            ],
            [
                'name'      => 'Matemáticas Financieras',
                'type'      => 'AEA-1170',
                'period'    => 'IADM-2010-213',
                'career_id' => 5,
            ],
            [
                'name'      => 'Dirección Empresarial',
                'type'      => 'AEA-1072',
                'period'    => 'IADM-2010-213',
                'career_id' => 5,
            ],
            [
                'name'      => 'Introducción al Derecho',
                'type'      => 'AEA-1143',
                'period'    => 'IADM-2010-213',
                'career_id' => 5,
            ],

            // ================================
            //  CARRERA 6 — ELECTROMECÁNICA
            //  PERIODO: IEME-2010-210
            // ================================
            [
                'name'      => 'Circuitos Eléctricos',
                'type'      => 'AEE-1109',
                'period'    => 'IEME-2010-210',
                'career_id' => 6,
            ],
            [
                'name'      => 'Electrónica Analógica',
                'type'      => 'AEE-1158',
                'period'    => 'IEME-2010-210',
                'career_id' => 6,
            ],
            [
                'name'      => 'Electrónica Digital',
                'type'      => 'AEE-1159',
                'period'    => 'IEME-2010-210',
                'career_id' => 6,
            ],
            [
                'name'      => 'Máquinas Eléctricas',
                'type'      => 'AEE-1189',
                'period'    => 'IEME-2010-210',
                'career_id' => 6,
            ],
            [
                'name'      => 'Dibujo Industrial',
                'type'      => 'AEM-1070',
                'period'    => 'IEME-2010-210',
                'career_id' => 6,
            ],
            [
                'name'      => 'Termodinámica',
                'type'      => 'AEM-1299',
                'period'    => 'IEME-2010-210',
                'career_id' => 6,
            ],
            [
                'name'      => 'Materiales Metálicos',
                'type'      => 'AEM-1172',
                'period'    => 'IEME-2010-210',
                'career_id' => 6,
            ],
            [
                'name'      => 'Procesos de Manufactura',
                'type'      => 'AEM-1255',
                'period'    => 'IEME-2010-210',
                'career_id' => 6,
            ],
            [
                'name'      => 'Hidráulica y Neumática',
                'type'      => 'AEM-1138',
                'period'    => 'IEME-2010-210',
                'career_id' => 6,
            ],
            [
                'name'      => 'Sistemas de Control',
                'type'      => 'AEM-1310',
                'period'    => 'IEME-2010-210',
                'career_id' => 6,
            ],

            // ================================
            //  CARRERA 7 — ENERGÍAS RENOVABLES
            //  PERIODO: IENR-2010-217
            // ================================
            [
                'name'      => 'Fundamentos de Energías Renovables',
                'type'      => 'AER-1002',
                'period'    => 'IENR-2010-217',
                'career_id' => 7,
            ],
            [
                'name'      => 'Sistemas Fotovoltaicos',
                'type'      => 'AER-1310',
                'period'    => 'IENR-2010-217',
                'career_id' => 7,
            ],
            [
                'name'      => 'Energía Eólica',
                'type'      => 'AER-1110',
                'period'    => 'IENR-2010-217',
                'career_id' => 7,
            ],
            [
                'name'      => 'Energía Solar Térmica',
                'type'      => 'AER-1115',
                'period'    => 'IENR-2010-217',
                'career_id' => 7,
            ],
            [
                'name'      => 'Biomasa y Biocombustibles',
                'type'      => 'AER-1088',
                'period'    => 'IENR-2010-217',
                'career_id' => 7,
            ],
            [
                'name'      => 'Eficiencia Energética',
                'type'      => 'AER-1105',
                'period'    => 'IENR-2010-217',
                'career_id' => 7,
            ],
            [
                'name'      => 'Sistemas Térmicos',
                'type'      => 'AER-1305',
                'period'    => 'IENR-2010-217',
                'career_id' => 7,
            ],
            [
                'name'      => 'Química Aplicada a Energías',
                'type'      => 'AER-1055',
                'period'    => 'IENR-2010-217',
                'career_id' => 7,
            ],
            [
                'name'      => 'Instrumentación y Medición Energética',
                'type'      => 'AER-1180',
                'period'    => 'IENR-2010-217',
                'career_id' => 7,
            ],
            [
                'name'      => 'Sistemas Eléctricos',
                'type'      => 'AER-1315',
                'period'    => 'IENR-2010-217',
                'career_id' => 7,
            ],


        ]);
    }
}
