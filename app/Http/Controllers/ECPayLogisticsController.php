<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;


class ECPayLogisticsController extends Controller
{

    public $szHashKey;
    public $szHashIV;

    public $szPlatformID;
    public $szMerchantID;
    public $szATMInfo;
    public $szCVSInfo;
    public $szBarcodeInfo;
    public $SC;

    function __construct()
    {
        $this->SC = new SettingController;
        //介接資訊
        $this->szHashKey = $this->SC->get('ecpay_HashKey');
        $this->szHashIV = $this->SC->get('ecpay_HashIV');
        /*************************************POST參數設置************************************************************/
        $this->szPlatformID = '';
        $this->szMerchantID = $this->SC->get('ecpay_MerchantID');
        $this->szATMInfo = '';
        $this->szCVSInfo = '';
        $this->szBarcodeInfo = '';
    }
    /*************************************加解密****************************************************************/
    public function Encrypt($arData)
    {
        // 轉Json格式
        $szData = json_encode($arData);
        // 做urlencode
        $szData = urlencode($szData);
        // AES
        $oCrypter = new AESCrypter($this->szHashKey, $this->szHashIV);
        // 加密 Data 參數內容
        $szData = $oCrypter->Encrypt($szData);
        return $szData;
    }
    public function Decrypt(String $data = '')
    {
        $oCrypter = new AESCrypter($this->szHashKey, $this->szHashIV);
        return json_decode($oCrypter->Decrypt($data), true);
    }

    /*************************************傳入綠界****************************************************************/
    public function sent2Server(NetworkService $oService, $arParameters)
    {
        //轉Json格式
        $arParameters = json_encode($arParameters);
        // 傳遞參數至遠端。
        if (config('app.env') == 'production') {
            $oService->ServiceURL = str_replace('-stage','',$oService->ServiceURL);
        }

        $szResult = $oService->ServerPost($arParameters);

        return $szResult;
    }

    // 開啟物流選擇頁
    public function LogisticsSelection()
    {


        $oService = new NetworkService();
        $oService->ServiceURL = 'https://logistics-stage.ecpay.com.tw/Express/v2/RedirectToLogisticsSelection';

        /*************************************要傳遞的 Data 參數******************************************************/
        $arData = array(

            //綠界暫存物流訂單編號
            'TempLogisticsID' => '0',

            //商品金額
            'GoodsAmount' => '20000',

            //是否代收貨款
            'IsCollection' => 'N',

            //代收金額
            //'CollectionAmount' => '20000',

            //商品名稱
            'GoodsName' => 'DearMe',

            //寄件人姓名
            'SenderName' => $this->SC->get('SenderName'),

            //寄件人電話
            'SenderPhone' => $this->SC->get('SenderPhone'),

            //寄件人手機
            'SenderCellPhone' => $this->SC->get('SenderCellPhone'),

            //寄件人郵遞區號
            'SenderZipCode' => $this->SC->get('SenderZipCode'),

            //寄件人地址
            'SenderAddress' => $this->SC->get('SenderAddress'),

            //交易描述
            'TradeDesc' => '交易描述',

            //備註
            'Remark' => '備註',

            //退貨門市代號
            //'ReturnStoreID' => '',

            //Server端回覆網址
            'ServerReplyURL' => 'http://b064-211-23-76-78.ngrok.io/php/LXnew/simple_ServerReplyPaymentStatus3.php',

            //Client端回覆網址
            'ClientReplyURL' => route('GetUserChooseLogistcs', ['s_id' => session()->getId()]),

            //溫層
            'Temperature' => '',

            //規格
            'Specification' => '',

            //預定取件時段
            'ScheduledPickupTime' => '4',

            //包裹件數
            'PackageCount' => '1',

            //收件人地址
            'ReceiverAddress' => '',

            //收件人郵遞區號
            'ReceiverZipCode' => '',

            //收件人手機
            'ReceiverCellPhone' => '',

            //收件人電話
            'ReceiverPhone' => '',

            //收件人姓名
            'ReceiverName' => '',

            //是否允許選擇送達時間
            'EnableSelectDeliveryTime' => 'Y',

            //廠商平台的會員ID   
            // 'EshopMemberID' => session()->getId(),
            // "EshopMemberID" => "xxxxyyyy123"
            // 'EshopMemberID' => 'test20210906',


        );
        /******************************************************************************************************************************************/

        // return $arData;
        date_default_timezone_set("Asia/Taipei");
        $szRqHeader = array(
            'Timestamp' => time(),
            'Revision' => '1.0.0',
        );

        // 加密 Data 參數內容
        $szData = $this->Encrypt($arData);

        //要POST的參數
        $arParameters = array(
            'MerchantID' => $this->szMerchantID,
            'RqHeader' => $szRqHeader,
            'Data' => $szData
        );


        $szResult = $this->sent2Server($oService, $arParameters);
        return $szResult;
    }



    // 建立正式物流訂單
    public function CreateByTempTrade($TempLogisticsID, $MerchantTradeNo = null)
    {
        // return $TempLogisticsID .'_'. $MerchantTradeNo;

        $oService = new NetworkService();
        $oService->ServiceURL = 'https://logistics-stage.ecpay.com.tw/Express/v2/CreateByTempTrade';

        /*************************************要傳遞的 Data 參數******************************************************/
        $arData = array(
            //暫存物流訂單編號
            'TempLogisticsID' => $TempLogisticsID,
            // 廠商交易編號
            'MerchantTradeNo' => $MerchantTradeNo ?? '',
        );
        /******************************************************************************************************************************************/

        // return $arData;
        date_default_timezone_set("Asia/Taipei");
        $szRqHeader = array(
            'Timestamp' => time(),
            'Revision' => '1.0.0',
        );

        // 加密 Data 參數內容
        $szData = $this->Encrypt($arData);

        //要POST的參數
        $arParameters = array(
            'MerchantID' => $this->szMerchantID,
            'RqHeader' => $szRqHeader,
            'Data' => $szData
        );


        $szResult = $this->sent2Server($oService, $arParameters);
        return $this->Decrypt(json_decode($szResult, true)['Data']);
    }

    // 列印託運單
    public function PrintTradeDocument($LogisticsSubType, $LogisticsIDs)
    {
        // return $TempLogisticsID .'_'. $MerchantTradeNo;

        $oService = new NetworkService();
        $oService->ServiceURL = 'https://logistics-stage.ecpay.com.tw/Express/v2/PrintTradeDocument';

        /*************************************要傳遞的 Data 參數******************************************************/
        $arData = array(
            'MerchantID' => $this->szMerchantID,
            // 物流子類型 
            'LogisticsSubType' => $LogisticsSubType,
            // 綠界訂單編號
            'LogisticsID' => $LogisticsIDs,
        );
        /******************************************************************************************************************************************/

        // return $arData;
        date_default_timezone_set("Asia/Taipei");
        $szRqHeader = array(
            'Timestamp' => time(),
            'Revision' => '1.0.0',
        );

        // 加密 Data 參數內容
        $szData = $this->Encrypt($arData);

        //要POST的參數
        $arParameters = array(
            'MerchantID' => $this->szMerchantID,
            'RqHeader' => $szRqHeader,
            'Data' => $szData
        );


        $szResult = $this->sent2Server($oService, $arParameters);
        return $szResult;
        // return $this->Decrypt(json_decode($szResult, true)['Data']);
    }

    // 建立暫存物流訂單結果通知
    public function GetUserChooseLogistcs(Request $request)
    {
        $old_s_id = $request->input('s_id');
        // return $old_s_id;
        $order = 'App\Models\Order'::where('session_id', $old_s_id)->first();
        $order->session_id = session()->getId();
        // $order->save();
        // return $order;
        // return $this->Decrypt($request->input('ResultData'));
        $res =  $this->Decrypt(json_decode($request->input('ResultData'), true)['Data']);
        // $order =  (new CartController())->getCartDatas();
        // return session()->get('order_sesscion_id');
        // return $order;
        $order->logistics_id = $res['TempLogisticsID'];
        $order->ship_type = $res['LogisticsType'] . "_" . $res['LogisticsSubType'];
        $order->ship_cost = 60;
        $order->receiver_name = $res['ReceiverName'];
        $order->receiver_phone = $res['ReceiverCellPhone'];
        if ($res['LogisticsType'] == 'CVS') {
            $order->receiver_address = $res['ReceiverStoreName'] . '(' . $res['ReceiverStoreID'] . ')';
        } else if ($res['LogisticsType'] == 'HOME') {
            $order->receiver_address = $res['ReceiverZipCode'] . $res['ReceiverAddress'];
        }
        $receiver_note = '';
        if ($res['ScheduledDeliveryTime']) {
            $ScheduledDeliveryTime = [
                '1' => '13點前',
                '2' => '14點 ~ 18點',
                '4' => '不限時',
            ];
            $receiver_note = $receiver_note . '預定送達時段 => ' . $ScheduledDeliveryTime[$res['ScheduledDeliveryTime']] . '\n';
        }
        if ($res['ScheduledDeliveryDate']) {
            $receiver_note = $receiver_note . '預定送達日期 => ' . $res['ScheduledDeliveryDate'] . '\n';
        }
        if ($receiver_note) {
            $order->receiver_note = $receiver_note . '----------------\n';
        }
        $order->save();
        $data = [
            'order' => $order
        ];

        // return $data;
        return redirect()->route('checkAndPayPage');
    }
}



/**
 * 呼叫網路服務的類別。
 */
class NetworkService
{

    /**
     * 網路服務類別呼叫的位址。
     */
    public $ServiceURL = 'ServiceURL';

    /**
     * 網路服務類別的建構式。
     */
    function __construct()
    {
        $this->NetworkService();
    }

    /**
     * 網路服務類別的實體。
     */
    function NetworkService()
    {
    }

    /**
     * 提供伺服器端呼叫遠端伺服器 Web API 的方法。
     */
    function ServerPost($parameters)
    {
        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, $this->ServiceURL);

        curl_setopt($ch, CURLOPT_HEADER, FALSE);
        //curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.8.1.13) Gecko/20080311 Firefox/2.0.0.13');

        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($ch, CURLOPT_POST, TRUE);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $parameters);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json; charset=utf-8', 'Content-Length: ' . strlen($parameters)));
        $rs = curl_exec($ch);

        curl_close($ch);

        return $rs;
    }
}


/**
 * AES 加解密服務的類別。
 */
class AesCrypter
{

    private $Key = 'pwFHCqoQZGmho4w6';
    private $IV = 'EkRm7iFT261dpevs';
    //private $Key = 'VogCRpshqJnZK4Me';
    //private $IV = 'CiQh3B0mZ6FbPmXk';

    /**
     * AES 加解密服務類別的建構式。
     */
    function __construct($key, $iv)
    {
        $this->AesCrypter($key, $iv);
    }

    /**
     * AES 加解密服務類別的實體。
     */
    function AesCrypter($key, $iv)
    {
        $this->Key = $key;
        $this->IV = $iv;
    }

    /**
     * 加密服務的方法。
     */
    function Encrypt($data)
    {
        $szData = openssl_encrypt($data, 'AES-128-CBC', $this->Key, OPENSSL_RAW_DATA, $this->IV);
        $szData = base64_encode($szData);

        return $szData;
    }

    /**
     * 解密服務的方法。
     */
    function Decrypt($data)
    {
        $szValue = openssl_decrypt(base64_decode($data), 'AES-128-CBC', $this->Key, OPENSSL_RAW_DATA, $this->IV);
        $szValue = urldecode($szValue);
        return $szValue;
    }
}
