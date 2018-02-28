<?php

/* @var $this yii\web\View */

$this->title = 'My Yii Application';
?>
<div class="site-index">

    <div class="body-content">

        <div id="menu">
            <div id="tree"></div>
        </div>
        <div id="content">
            <table class="table1">
                <tbody>
                <tr>
                    <td class="td1">
                        <label for="garnum">
                            Гаражный номер объекта
                        </label>
                    </td>
                    <td class="td1">
                        <div id="garnum"></div>
                    </td>
                    <td class="td1">
                        <label for="gosnum">
                            Гос. номер объекта
                        </label>
                    </td>
                    <td class="td1">
                        <div id="gosnum"></div>
                    </td>
                    <td class="td1">
                        <label for="vin">
                            VIN (Идентификационный номер транспортного средства)
                        </label>
                    </td>
                    <td class="td1">
                        <div id="vin"></div>
                    </td>
                </tr>
                </tbody>
            </table>
            <table>
                <tr>
                    <td>
                        Контроллер
                    </td>
                </tr>
            </table>
            <tablec0></tablec0>
            <table>
                <tr>
                    <td   >
                        Датчики
                    </td>
                </tr>
            </table>
            <tables0></tables0>
            <br>
            <table>
                <tr>
                    <td>
                        Контроллер
                    </td>
                </tr>
            </table>
            <tablec1></tablec1>
            <table>
                <tr>
                    <td>
                        Датчики
                    </td>
                </tr>
            </table>
            <tables1></tables1>
            <h5>
                <div id="rezult"></div>
            </h5>
        </div>

        <div id="map"></div>

        <script async defer
                src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAkAmxa_5WTQAvy62MCkTOvA-FAJOZBFiI&callback=initMap">
        </script>

    </div>
</div>
