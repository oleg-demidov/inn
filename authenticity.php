<?php

/*
 * OLeg Demidov
 * ------------------------------------------------------
 * Contact e-mail: end-fin@yandex.ru
 *
 * GNU General Public License, version 2:
 * http://www.gnu.org/licenses/old-licenses/gpl-2.0.html
 *
 * ------------------------------------------------------
 *
 * @link https://vk.com/u_demidova
 * @author Oleg Demidov <end-fin@yandex.ru>
 *
 */

/**
 * Description of authenticity
 *
 * @author oleg
 */
class Authenticity {

    protected $sUrl = 'https://pb.nalog.ru/search-proc.json';
    /**
     * Возвращает информацию о недедостоверности ИНН 
     * 
     * @param string $sInn
     * 
     * @return array
     */
    public function get(string $sInn) {
        /*
         * Получаем все данные о ИНН
         */
        $aData = $this->query($sInn);
        
        /*
         * Если присутствует данные о недобросовестности
         */
        if (isset($aData['ogrfl']['data']) && $aData['ogrfl']['data']) 
        {
            return [
                'inn'       => $sInn,
                'message'   => 'Наличие признака недостоверности',
                'authenticity' => false
            ];
        }
        else
        {
            return [
                'inn'       => $sInn,
                'message'   => 'По заданным критериям поиска сведений не найдено.',
                'authenticity' => true
            ];
        }
    }
        
    /**
     * Плучить все данные о ИНН
     * 
     * @param string $sInn
     * @return array
     */
    protected function query(string $sInn) {
        /*
         * Массив параметров
         */
        $aQuery = [
            'query' => $sInn
        ];
        $streamContext = stream_context_create(
            array(
                'http'    => array(
                    'header'    => "Accept-language: en". PHP_EOL 
                        ."Content-type: application/x-www-form-urlencoded" . PHP_EOL
                        ."User-Agent: Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/77.0.3865.120 YaBrowser/19.10.3.302 (beta) Yowser/2.5 Safari/537.36" . PHP_EOL
                )
            )
        );

        $sJsonData = file_get_contents(
            $this->sUrl . '?' . http_build_query($aQuery), 
            false, 
            $streamContext); 
        
        return json_decode($sJsonData, true);
    }
}
