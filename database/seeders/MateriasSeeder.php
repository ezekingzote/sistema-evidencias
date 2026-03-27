<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class MateriasSeeder extends Seeder
{
    public function run(): void
    {
        $ahora = Carbon::now();

        $carreras = [
            'Ingeniería en Sistemas Computacionales' => [

                ['nombre' => 'Cálculo Diferencial', 'clave' => 'ACF-0901', 'unidades' => 5, 'semestre' => 1],
                ['nombre' => 'Fundamentos de Programación', 'clave' => 'AED-1285', 'unidades' => 5, 'semestre' => 1],
                ['nombre' => 'Taller de Ética', 'clave' => 'ACA-0907', 'unidades' => 4, 'semestre' => 1],
                ['nombre' => 'Matemáticas Discretas', 'clave' => 'AEF-1041', 'unidades' => 6, 'semestre' => 1],
                ['nombre' => 'Taller de Administración', 'clave' => 'SCH-1024', 'unidades' => 6, 'semestre' => 1],
                ['nombre' => 'Fundamentos de Investigación', 'clave' => 'ACC-0906', 'unidades' => 4, 'semestre' => 1],

                ['nombre' => 'Cálculo Integral', 'clave' => 'ACF-0902', 'unidades' => 4, 'semestre' => 2],
                ['nombre' => 'Programación Orientada a Objetos', 'clave' => 'AED-1286', 'unidades' => 6, 'semestre' => 2],
                ['nombre' => 'Contabilidad Financiera', 'clave' => 'AEC-1008', 'unidades' => 5, 'semestre' => 2],
                ['nombre' => 'Química', 'clave' => 'AEC-1058', 'unidades' => 4, 'semestre' => 2],
                ['nombre' => 'Álgebra Lineal', 'clave' => 'ACF-0903', 'unidades' => 5, 'semestre' => 2],
                ['nombre' => 'Probabilidad y Estadística', 'clave' => 'AEF-1052', 'unidades' => 6, 'semestre' => 2],

                ['nombre' => 'Cálculo Vectorial', 'clave' => 'ACF-0904', 'unidades' => 5, 'semestre' => 3],
                ['nombre' => 'Estructura de Datos', 'clave' => 'AED-1026', 'unidades' => 6, 'semestre' => 3],
                ['nombre' => 'Cultura Empresarial', 'clave' => 'SCC-1005', 'unidades' => 5, 'semestre' => 3],
                ['nombre' => 'Investigación de Operaciones', 'clave' => 'SCC-1013', 'unidades' => 5, 'semestre' => 3],
                ['nombre' => 'Desarrollo Sustentable', 'clave' => 'ACD-0908', 'unidades' => 5, 'semestre' => 3],
                ['nombre' => 'Física General', 'clave' => 'SCF-1006', 'unidades' => 7, 'semestre' => 3],

                ['nombre' => 'Ecuaciones Diferenciales', 'clave' => 'ACF-0905', 'unidades' => 5, 'semestre' => 4],
                ['nombre' => 'Métodos Numéricos', 'clave' => 'SCC-1017', 'unidades' => 6, 'semestre' => 4],
                ['nombre' => 'Tópicos Avanzados de Programación', 'clave' => 'SCD-1027', 'unidades' => 5, 'semestre' => 4],
                ['nombre' => 'Fundamentos de Base de Datos', 'clave' => 'AEF-1031', 'unidades' => 6, 'semestre' => 4],
                ['nombre' => 'Simulación', 'clave' => 'SCD-1022', 'unidades' => 5, 'semestre' => 4],
                ['nombre' => 'Principios Eléctricos y Aplicaciones Digitales', 'clave' => 'SCD-1018', 'unidades' => 4, 'semestre' => 4],

                ['nombre' => 'Graficación', 'clave' => 'SCC-1010', 'unidades' => 5, 'semestre' => 5],
                ['nombre' => 'Fundamentos de Telecomunicaciones', 'clave' => 'AEC-1034', 'unidades' => 5, 'semestre' => 5],
                ['nombre' => 'Sistemas Operativos I', 'clave' => 'AEC-1061', 'unidades' => 6, 'semestre' => 5],
                ['nombre' => 'Taller de Base de Datos', 'clave' => 'SCA-1025', 'unidades' => 6, 'semestre' => 5],
                ['nombre' => 'Fundamentos de Ingeniería de Software', 'clave' => 'SCC-1007', 'unidades' => 5, 'semestre' => 5],
                ['nombre' => 'Arquitectura de Computadoras', 'clave' => 'SCD-1003', 'unidades' => 4, 'semestre' => 5],

                ['nombre' => 'Lenguajes y Autómatas I', 'clave' => 'SCD-1015', 'unidades' => 6, 'semestre' => 6],
                ['nombre' => 'Redes de Computadoras', 'clave' => 'SCD-1021', 'unidades' => 5, 'semestre' => 6],
                ['nombre' => 'Taller de Sistemas Operativos', 'clave' => 'SCA-1026', 'unidades' => 4, 'semestre' => 6],
                ['nombre' => 'Administración de Base de Datos', 'clave' => 'SCB-1001', 'unidades' => 6, 'semestre' => 6],
                ['nombre' => 'Ingeniería de Software', 'clave' => 'SCD-1011', 'unidades' => 4, 'semestre' => 6],
                ['nombre' => 'Lenguajes de Interfaz', 'clave' => 'SCC-1014', 'unidades' => 4, 'semestre' => 6],

                ['nombre' => 'Lenguajes y Autómatas II', 'clave' => 'SCD-1016', 'unidades' => 4, 'semestre' => 7],
                ['nombre' => 'Conmutación y Enrutamiento en Redes de Datos', 'clave' => 'SCD-1004', 'unidades' => 4, 'semestre' => 7],
                ['nombre' => 'Taller de Investigación I', 'clave' => 'ACA-0909', 'unidades' => 3, 'semestre' => 7],
                ['nombre' => 'Gestión de Proyectos de Software', 'clave' => 'SCG-1009', 'unidades' => 5, 'semestre' => 7],
                ['nombre' => 'Sistemas Programables', 'clave' => 'SCC-1023', 'unidades' => 6, 'semestre' => 7],

                ['nombre' => 'Programación Lógica y Funcional', 'clave' => 'SCC-1019', 'unidades' => 4, 'semestre' => 8],
                ['nombre' => 'Administración de Redes', 'clave' => 'SCA-1002', 'unidades' => 4, 'semestre' => 8],
                ['nombre' => 'Taller de Investigación II', 'clave' => 'ACA-0910', 'unidades' => 3, 'semestre' => 8],
                ['nombre' => 'Programación Web', 'clave' => 'AEB-1055', 'unidades' => 5, 'semestre' => 8],

                ['nombre' => 'Inteligencia Artificial', 'clave' => 'SCC-1012', 'unidades' => 4, 'semestre' => 9],

            ],

            'Ingeniería Industrial' => [

                ['nombre' => 'Fundamentos de Investigación', 'clave' => 'ACC-0906', 'unidades' => 4, 'semestre' => 1],
                ['nombre' => 'Taller de Ética', 'clave' => 'ACA-0907', 'unidades' => 4, 'semestre' => 1],
                ['nombre' => 'Cálculo Diferencial', 'clave' => 'ACF-0901', 'unidades' => 5, 'semestre' => 1],
                ['nombre' => 'Taller de Herramientas Intelectuales', 'clave' => 'INH-1029', 'unidades' => 5, 'semestre' => 1],
                ['nombre' => 'Química', 'clave' => 'INC-1025', 'unidades' => 5, 'semestre' => 1],
                ['nombre' => 'Dibujo Industrial', 'clave' => 'INN-1008', 'unidades' => 4, 'semestre' => 1],

                ['nombre' => 'Electricidad y Electrónica Industrial', 'clave' => 'INC-1009', 'unidades' => 4, 'semestre' => 2],
                ['nombre' => 'Propiedades de los Materiales', 'clave' => 'INC-1024', 'unidades' => 4, 'semestre' => 2],
                ['nombre' => 'Cálculo Integral', 'clave' => 'ACF-0902', 'unidades' => 4, 'semestre' => 2],
                ['nombre' => 'Probabilidad y Estadística', 'clave' => 'AEC-1053', 'unidades' => 6, 'semestre' => 2],
                ['nombre' => 'Análisis de la Realidad Nacional', 'clave' => 'INQ-1006', 'unidades' => 3, 'semestre' => 2],
                ['nombre' => 'Taller de Liderazgo', 'clave' => 'INC-1030', 'unidades' => 4, 'semestre' => 2],

                ['nombre' => 'Metrología y Normalización', 'clave' => 'AEC-1048', 'unidades' => 3, 'semestre' => 3],
                ['nombre' => 'Álgebra Lineal', 'clave' => 'ACF-0903', 'unidades' => 5, 'semestre' => 3],
                ['nombre' => 'Cálculo Vectorial', 'clave' => 'ACF-0904', 'unidades' => 5, 'semestre' => 3],
                ['nombre' => 'Economía', 'clave' => 'AEC-1018', 'unidades' => 5, 'semestre' => 3],
                ['nombre' => 'Estadística Inferencial I', 'clave' => 'AEF-1024', 'unidades' => 5, 'semestre' => 3],
                ['nombre' => 'Estudio del Trabajo I', 'clave' => 'INJ-1011', 'unidades' => 4, 'semestre' => 3],

                ['nombre' => 'Procesos de Fabricación', 'clave' => 'INC-1023', 'unidades' => 6, 'semestre' => 4],
                ['nombre' => 'Física', 'clave' => 'INC-1013', 'unidades' => 5, 'semestre' => 4],
                ['nombre' => 'Algoritmos y Lenguajes de Programación', 'clave' => 'INC-1005', 'unidades' => 6, 'semestre' => 4],
                ['nombre' => 'Investigación de Operaciones I', 'clave' => 'INC-1018', 'unidades' => 4, 'semestre' => 4],
                ['nombre' => 'Estadística Inferencial II', 'clave' => 'AEF-1025', 'unidades' => 5, 'semestre' => 4],
                ['nombre' => 'Estudio del Trabajo II', 'clave' => 'INJ-1012', 'unidades' => 4, 'semestre' => 4],
                ['nombre' => 'Higiene y Seguridad Industrial', 'clave' => 'INF-1016', 'unidades' => 7, 'semestre' => 4],

                ['nombre' => 'Administración de Proyectos', 'clave' => 'INR-1003', 'unidades' => 4, 'semestre' => 5],
                ['nombre' => 'Gestión de Costos', 'clave' => 'AEC-1392', 'unidades' => 5, 'semestre' => 5],
                ['nombre' => 'Administración de las Operaciones I', 'clave' => 'INC-1001', 'unidades' => 5, 'semestre' => 5],
                ['nombre' => 'Investigación de Operaciones II', 'clave' => 'INC-1019', 'unidades' => 5, 'semestre' => 5],
                ['nombre' => 'Control Estadístico de la Calidad', 'clave' => 'INF-1007', 'unidades' => 4, 'semestre' => 5],
                ['nombre' => 'Ergonomía', 'clave' => 'INF-1010', 'unidades' => 4, 'semestre' => 5],
                ['nombre' => 'Desarrollo Sustentable', 'clave' => 'ACD-0908', 'unidades' => 5, 'semestre' => 5],

                ['nombre' => 'Taller de Investigación I', 'clave' => 'ACA-0909', 'unidades' => 3, 'semestre' => 6],
                ['nombre' => 'Ingeniería Económica', 'clave' => 'AEC-1037', 'unidades' => 4, 'semestre' => 6],
                ['nombre' => 'Administración de las Operaciones II', 'clave' => 'INC-1002', 'unidades' => 4, 'semestre' => 6],
                ['nombre' => 'Simulación', 'clave' => 'INC-1027', 'unidades' => 6, 'semestre' => 6],
                ['nombre' => 'Administración del Mantenimiento', 'clave' => 'INC-1004', 'unidades' => 5, 'semestre' => 6],
                ['nombre' => 'Mercadotecnia', 'clave' => 'AED-1044', 'unidades' => 5, 'semestre' => 6],

                ['nombre' => 'Taller de Investigación II', 'clave' => 'ACA-0910', 'unidades' => 3, 'semestre' => 7],
                ['nombre' => 'Planeación Financiera', 'clave' => 'INC-1021', 'unidades' => 5, 'semestre' => 7],
                ['nombre' => 'Planeación y Diseño de Instalaciones', 'clave' => 'INC-1022', 'unidades' => 3, 'semestre' => 7],
                ['nombre' => 'Sistemas de Manufactura', 'clave' => 'INF-1028', 'unidades' => 4, 'semestre' => 7],
                ['nombre' => 'Logística y Cadenas de Suministro', 'clave' => 'INH-1020', 'unidades' => 6, 'semestre' => 7],
                ['nombre' => 'Gestión de los Sistemas de Calidad', 'clave' => 'INC-1015', 'unidades' => 4, 'semestre' => 7],
                ['nombre' => 'Ingeniería de Sistemas', 'clave' => 'INR-1017', 'unidades' => 5, 'semestre' => 7],

                ['nombre' => 'Formulación y Evaluación de Proyectos', 'clave' => 'AED-1030', 'unidades' => 6, 'semestre' => 8],
                ['nombre' => 'Relaciones Industriales', 'clave' => 'INC-1026', 'unidades' => 5, 'semestre' => 8],

            ],
            'Ingeniería en Gestión Empresarial' => [

                ['nombre' => 'Fundamentos de Investigación', 'clave' => 'ACC-0906', 'unidades' => 4, 'semestre' => 1],
                ['nombre' => 'Cálculo Diferencial', 'clave' => 'ACF-0901', 'unidades' => 5, 'semestre' => 1],
                ['nombre' => 'Desarrollo Humano', 'clave' => 'GEC-0905', 'unidades' => 5, 'semestre' => 1],
                ['nombre' => 'Fundamentos de Gestión Empresarial', 'clave' => 'AEF-1074', 'unidades' => 6, 'semestre' => 1],
                ['nombre' => 'Fundamentos de Física', 'clave' => 'GEC-0909', 'unidades' => 4, 'semestre' => 1],
                ['nombre' => 'Fundamentos de Química', 'clave' => 'GEF-0910', 'unidades' => 4, 'semestre' => 1],

                ['nombre' => 'Software de Aplicación Ejecutivo', 'clave' => 'AEB-1082', 'unidades' => 4, 'semestre' => 2],
                ['nombre' => 'Cálculo Integral', 'clave' => 'ACF-0902', 'unidades' => 4, 'semestre' => 2],
                ['nombre' => 'Contabilidad Orientada a los Negocios', 'clave' => 'GED-0903', 'unidades' => 5, 'semestre' => 2],
                ['nombre' => 'Dinámica Social', 'clave' => 'AEC-1014', 'unidades' => 5, 'semestre' => 2],
                ['nombre' => 'Taller de Ética', 'clave' => 'ACA-0907', 'unidades' => 4, 'semestre' => 2],
                ['nombre' => 'Legislación Laboral', 'clave' => 'GEE-0918', 'unidades' => 6, 'semestre' => 2],

                ['nombre' => 'Marco Legal de las Organizaciones', 'clave' => 'AEC-1078', 'unidades' => 5, 'semestre' => 3],
                ['nombre' => 'Probabilidad y Estadística Descriptiva', 'clave' => 'GED-0921', 'unidades' => 4, 'semestre' => 3],
                ['nombre' => 'Costos Empresariales', 'clave' => 'GED-0904', 'unidades' => 6, 'semestre' => 3],
                ['nombre' => 'Habilidades Directivas I', 'clave' => 'GEC-0913', 'unidades' => 5, 'semestre' => 3],
                ['nombre' => 'Economía Empresarial', 'clave' => 'AEF-1071', 'unidades' => 5, 'semestre' => 3],
                ['nombre' => 'Álgebra Lineal', 'clave' => 'ACF-0903', 'unidades' => 5, 'semestre' => 3],

                ['nombre' => 'Ingeniería Económica', 'clave' => 'GEF-0916', 'unidades' => 5, 'semestre' => 4],
                ['nombre' => 'Estadística Inferencial I', 'clave' => 'GEG-0907', 'unidades' => 5, 'semestre' => 4],
                ['nombre' => 'Instrumentos de Presupuestación Empresarial', 'clave' => 'GED-0917', 'unidades' => 5, 'semestre' => 4],
                ['nombre' => 'Habilidades Directivas II', 'clave' => 'GEC-0914', 'unidades' => 5, 'semestre' => 4],
                ['nombre' => 'Entorno Macroeconómico', 'clave' => 'GEF-0906', 'unidades' => 6, 'semestre' => 4],
                ['nombre' => 'Investigación de Operaciones', 'clave' => 'AEF-1076', 'unidades' => 6, 'semestre' => 4],

                ['nombre' => 'Finanzas en las Organizaciones', 'clave' => 'AEF-1073', 'unidades' => 5, 'semestre' => 5],
                ['nombre' => 'Estadística Inferencial II', 'clave' => 'GEG-0908', 'unidades' => 5, 'semestre' => 5],
                ['nombre' => 'Ingeniería de Procesos', 'clave' => 'GEF-0915', 'unidades' => 4, 'semestre' => 5],
                ['nombre' => 'Gestión del Capital Humano', 'clave' => 'AEG-1075', 'unidades' => 6, 'semestre' => 5],
                ['nombre' => 'Taller de Investigación I', 'clave' => 'ACA-0909', 'unidades' => 3, 'semestre' => 5],
                ['nombre' => 'Mercadotecnia', 'clave' => 'GEF-0919', 'unidades' => 7, 'semestre' => 5],

                ['nombre' => 'Administración de la Salud y Seguridad Ocupacional', 'clave' => 'GEF-0901', 'unidades' => 6, 'semestre' => 6],
                ['nombre' => 'El Emprendedor y la Innovación', 'clave' => 'AED-1072', 'unidades' => 5, 'semestre' => 6],
                ['nombre' => 'Gestión de la Producción I', 'clave' => 'GEC-0911', 'unidades' => 6, 'semestre' => 6],
                ['nombre' => 'Diseño Organizacional', 'clave' => 'AED-1015', 'unidades' => 6, 'semestre' => 6],
                ['nombre' => 'Taller de Investigación II', 'clave' => 'ACA-0910', 'unidades' => 3, 'semestre' => 6],
                ['nombre' => 'Sistemas de Información de Mercadotecnia', 'clave' => 'GED-0922', 'unidades' => 5, 'semestre' => 6],

                ['nombre' => 'Calidad Aplicada a la Gestión Empresarial', 'clave' => 'AED-1069', 'unidades' => 6, 'semestre' => 7],
                ['nombre' => 'Plan de Negocios', 'clave' => 'GED-0920', 'unidades' => 7, 'semestre' => 7],
                ['nombre' => 'Gestión de la Producción II', 'clave' => 'GEC-0912', 'unidades' => 5, 'semestre' => 7],
                ['nombre' => 'Gestión Estratégica', 'clave' => 'AED-1035', 'unidades' => 6, 'semestre' => 7],
                ['nombre' => 'Desarrollo Sustentable', 'clave' => 'ACD-0908', 'unidades' => 5, 'semestre' => 7],
                ['nombre' => 'Mercadotecnia Electrónica', 'clave' => 'AEB-1045', 'unidades' => 5, 'semestre' => 7],

                ['nombre' => 'Cadena de Suministros', 'clave' => 'GEF-0902', 'unidades' => 6, 'semestre' => 8],

            ],
            'Licenciatura en Turismo' => [

                ['nombre' => 'Fundamentos del Turismo', 'clave' => 'LTC-1218', 'unidades' => 6, 'semestre' => 1],
                ['nombre' => 'Administración de Empresas Turísticas', 'clave' => 'LTD-1201', 'unidades' => 6, 'semestre' => 1],
                ['nombre' => 'Flora', 'clave' => 'LTC-1215', 'unidades' => 5, 'semestre' => 1],
                ['nombre' => 'Matemáticas Aplicadas al Turismo', 'clave' => 'LTD-1226', 'unidades' => 3, 'semestre' => 1],
                ['nombre' => 'Fundamentos de Investigación', 'clave' => 'ACC-0906', 'unidades' => 4, 'semestre' => 1],
                ['nombre' => 'Taller de Ética', 'clave' => 'ACA-0907', 'unidades' => 4, 'semestre' => 1],

                ['nombre' => 'Historia del Arte Mexicano', 'clave' => 'LTF-1223', 'unidades' => 5, 'semestre' => 2],
                ['nombre' => 'Contabilidad Financiera', 'clave' => 'LTD-1205', 'unidades' => 5, 'semestre' => 2],
                ['nombre' => 'Cartografía', 'clave' => 'LTF-1203', 'unidades' => 4, 'semestre' => 2],
                ['nombre' => 'Fundamentos de Derecho', 'clave' => 'LTC-1216', 'unidades' => 5, 'semestre' => 2],
                ['nombre' => 'Fauna', 'clave' => 'LTC-1214', 'unidades' => 6, 'semestre' => 2],
                ['nombre' => 'Seguridad y Supervivencia', 'clave' => 'LTD-1231', 'unidades' => 5, 'semestre' => 2],

                ['nombre' => 'Socioantropología Turística', 'clave' => 'LTF-1232', 'unidades' => 3, 'semestre' => 3],
                ['nombre' => 'Estadística Aplicada al Turismo', 'clave' => 'LTC-1213', 'unidades' => 5, 'semestre' => 3],
                ['nombre' => 'Ecología', 'clave' => 'LTF-1208', 'unidades' => 5, 'semestre' => 3],
                ['nombre' => 'Meteorología y Climatología', 'clave' => 'LTF-1228', 'unidades' => 4, 'semestre' => 3],
                ['nombre' => 'Herramientas Informáticas Administrativas', 'clave' => 'LTD-1222', 'unidades' => 5, 'semestre' => 3],
                ['nombre' => 'Turismo de Aventura I', 'clave' => 'LTM-1233', 'unidades' => 7, 'semestre' => 3],

                ['nombre' => 'Patrimonio Turístico Cultural', 'clave' => 'LTC-1230', 'unidades' => 3, 'semestre' => 4],
                ['nombre' => 'Fundamentos de Mercadotecnia Turística', 'clave' => 'LTF-1217', 'unidades' => 6, 'semestre' => 4],
                ['nombre' => 'Geomorfología', 'clave' => 'LTD-1220', 'unidades' => 5, 'semestre' => 4],
                ['nombre' => 'Turismo de Aventura II', 'clave' => 'LTD-1234', 'unidades' => 6, 'semestre' => 4],
                ['nombre' => 'Comunicación y Relaciones Humanas', 'clave' => 'LTF-1204', 'unidades' => 4, 'semestre' => 4],
                ['nombre' => 'Manejo de Recursos Naturales e Impacto Ambiental', 'clave' => 'LTD-1224', 'unidades' => 6, 'semestre' => 4],

                ['nombre' => 'Desarrollo Sustentable', 'clave' => 'ACD-0908', 'unidades' => 5, 'semestre' => 5],
                ['nombre' => 'Geografía Turística de México', 'clave' => 'LTD-1219', 'unidades' => 7, 'semestre' => 5],
                ['nombre' => 'Ecoturismo I', 'clave' => 'LTM-1210', 'unidades' => 5, 'semestre' => 5],
                ['nombre' => 'Economía', 'clave' => 'LTF-1209', 'unidades' => 6, 'semestre' => 5],
                ['nombre' => 'Turismo Rural I', 'clave' => 'LTC-1235', 'unidades' => 5, 'semestre' => 5],
                ['nombre' => 'Diagnóstico y Evaluación del Sistema Turístico', 'clave' => 'LTM-1207', 'unidades' => 5, 'semestre' => 5],

                ['nombre' => 'Turismo Rural II', 'clave' => 'LTM-1236', 'unidades' => 5, 'semestre' => 6],
                ['nombre' => 'Taller de Investigación I', 'clave' => 'ACA-0909', 'unidades' => 3, 'semestre' => 6],
                ['nombre' => 'Ecoturismo II', 'clave' => 'LTM-1211', 'unidades' => 4, 'semestre' => 6],
                ['nombre' => 'Cosmovisión de los Pueblos Originarios', 'clave' => 'LTC-1206', 'unidades' => 5, 'semestre' => 6],
                ['nombre' => 'Marco Legal del Turismo y Protección al Medio Ambiente', 'clave' => 'LTF-1225', 'unidades' => 6, 'semestre' => 6],
                ['nombre' => 'Gestión del Desarrollo Turístico', 'clave' => 'LTM-1221', 'unidades' => 4, 'semestre' => 6],

                ['nombre' => 'Taller de Investigación II', 'clave' => 'ACA-0910', 'unidades' => 3, 'semestre' => 7],
                ['nombre' => 'Elaboración y Evaluación de Proyectos Turísticos', 'clave' => 'LTG-1212', 'unidades' => 7, 'semestre' => 7],
                ['nombre' => 'Mercadotecnia de Servicios Turísticos', 'clave' => 'LTF-1227', 'unidades' => 5, 'semestre' => 7],

                ['nombre' => 'Calidad del Servicio al Cliente', 'clave' => 'LTD-1202', 'unidades' => 5, 'semestre' => 8],
                ['nombre' => 'Operación de Servicios Turísticos', 'clave' => 'LTF-1229', 'unidades' => 6, 'semestre' => 8],

            ],
        ];

        foreach ($carreras as $carreraNombre => $listaMaterias) {
            foreach ($listaMaterias as $m) {
                DB::table('materias')->insert([
                    'nombre'     => $m['nombre'],
                    'clave'      => $m['clave'],
                    'unidades'   => $m['unidades'],
                    'semestre'   => $m['semestre'],
                    'carrera'    => $carreraNombre,
                    'activo'     => false,
                    'created_at' => $ahora,
                    'updated_at' => $ahora,
                ]);
            }
        }
    }
}
