<?php
require_once( 'config.php');

if( isset( $_POST['submit'] ) ){
	require_once( 'input/ExecTranInput.php');
	require_once( 'tran/ExecTran.php');

	//入力パラメータクラスをインスタンス化します
	$input = new ExecTranInput();/* @var $input ExecTranInput */

	//各種パラメータを設定します。

	//カード番号入力型・会員ID決済型に共通する値です。
	$input->setAccessId( $_POST['AccessID'] );
	$input->setAccessPass( $_POST['AccessPass'] );
	$input->setOrderId( $_POST['OrderID'] );

	//支払方法に応じて、支払回数のセット要否が異なります。
	$method = $_POST['PayMethod'];
	$input->setMethod( $method );
	if( $method == '2' || $method == '4'){//支払方法が、分割またはボーナス分割の場合、支払回数を設定します。
		$input->setPayTimes( $_POST['PayTimes'] );
	}

	//このサンプルでは、加盟店自由項目１～３を全て利用していますが、これらの項目は任意項目です。
	//利用しない場合、設定する必要はありません。
	//また、加盟店自由項目に２バイトコードを設定する場合、SJISに変換して設定してください。
	$input->setClientField1( mb_convert_encoding( $_POST['ClientField1'] , 'SJIS' , PGCARD_SAMPLE_ENCODING ) );
	$input->setClientField2( mb_convert_encoding( $_POST['ClientField2'] , 'SJIS' , PGCARD_SAMPLE_ENCODING ) );
	$input->setClientField3( mb_convert_encoding( $_POST['ClientField3'] , 'SJIS' , PGCARD_SAMPLE_ENCODING ) );
	$input->setDisplayInfo( mb_convert_encoding( $_POST['DisplayInfo'] , 'SJIS' , PGCARD_SAMPLE_ENCODING ) );

	//HTTP_ACCEPT,HTTP_USER_AGENTは、3Dセキュアサービスをご利用の場合のみ必要な項目です。
	//Entryで3D利用フラグをオンに設定した場合のみ、設定してください。
	//設定する場合、カード所有者のブラウザから送信されたリクエストヘッダの値を、無加工で
	//設定してください。
	$input->setHttpUserAgent( $_SERVER['HTTP_USER_AGENT']);
	$input->setHttpAccept( $_SERVER['HTTP_ACCEPT' ]);

	//ここから、カード番号入力型決済/トークン/会員ID型決済それぞれの場合で
	//異なるパラメータを設定します。

	//ここでは、トークン＞会員ID＞カード番号の優先順位で、カード情報を設定しています。
	$token    = $_POST['Token'];
	$tokenType    = $_POST['TokenType'];
	$memberId = $_POST['MemberID'];

	if( 0 < strlen( $token ) ){//トークン決済

		//トークン決済の場合、カード番号/有効期限/セキュリティコードの設定は不要です。
		//設定した場合無視され、トークン取得時に設定した値が適用されます。
		$input->setToken( $token );
		$input->setTokenType($tokenType);

	}elseif( 0 < strlen( $memberId )  ){//会員ID決済
		//サンプルでは、サイトID・サイトパスワードはコンスタント定義しています。
		$input->setSiteId( PGCARD_SITE_ID );
		$input->setSitePass( PGCARD_SITE_PASS );

		//会員IDは必須です。
		$input->setMemberId( $memberId );

		//登録カード連番は必須です。
		$cardSeq = $_POST['CardSeq'];
		if( 0< strlen( $cardSeq ) ){
			$input->setCardSeq( $cardSeq );
		}

	}else{//カード番号決済

		//カード番号・有効期限は必須です。
		$input->setCardNo( $_POST['CardNo'] );
		$input->setExpire( $_POST['Expire'] );

		//セキュリティコードは任意です。
		$input->setSecurityCode( $_POST['SecurityCode'] );
	}

	//以下のパラメータは3DS2.0を利用する場合に必要な項目です。
	//加盟店戻りURLのみ必須であり、他のパラメータは任意です。
	$input->setTds2ChAccChange( $_POST['Tds2ChAccChange'] );
	$input->setTds2ChAccDate( $_POST['Tds2ChAccDate'] );
	$input->setTds2ChAccPwChange( $_POST['Tds2ChAccPwChange'] );
	$input->setTds2NbPurchaseAccount( $_POST['Tds2NbPurchaseAccount'] );
	$input->setTds2PaymentAccAge( $_POST['Tds2PaymentAccAge'] );
	$input->setTds2ProvisionAttemptsDay( $_POST['Tds2ProvisionAttemptsDay'] );
	$input->setTds2ShipAddressUsage( $_POST['Tds2ShipAddressUsage'] );
	$input->setTds2ShipNameInd( $_POST['Tds2ShipNameInd'] );
	$input->setTds2SuspiciousAccActivity( $_POST['Tds2SuspiciousAccActivity'] );
	$input->setTds2TxnActivityDay( $_POST['Tds2TxnActivityDay'] );
	$input->setTds2TxnActivityYear( $_POST['Tds2TxnActivityYear'] );
	$input->setTds2ThreeDSReqAuthData( $_POST['Tds2ThreeDSReqAuthData'] );
	$input->setTds2ThreeDSReqAuthMethod( $_POST['Tds2ThreeDSReqAuthMethod'] );
	$input->setTds2ThreeDSReqAuthTimestamp( $_POST['Tds2ThreeDSReqAuthTimestamp'] );
	$input->setTds2AddrMatch( $_POST['Tds2AddrMatch'] );
	$input->setTds2BillAddrCity( $_POST['Tds2BillAddrCity'] );
	$input->setTds2BillAddrCountry( $_POST['Tds2BillAddrCountry'] );
	$input->setTds2BillAddrLine1( $_POST['Tds2BillAddrLine1'] );
	$input->setTds2BillAddrLine2( $_POST['Tds2BillAddrLine2'] );
	$input->setTds2BillAddrLine3( $_POST['Tds2BillAddrLine3'] );
	$input->setTds2BillAddrPostCode( $_POST['Tds2BillAddrPostCode'] );
	$input->setTds2BillAddrState( $_POST['Tds2BillAddrState'] );
	$input->setTds2Email( $_POST['Tds2Email'] );
	$input->setTds2HomePhoneCC( $_POST['Tds2HomePhoneCC'] );
	$input->setTds2HomePhoneSubscriber( $_POST['Tds2HomePhoneSubscriber'] );
	$input->setTds2MobilePhoneCC( $_POST['Tds2MobilePhoneCC'] );
	$input->setTds2MobilePhoneSubscriber( $_POST['Tds2MobilePhoneSubscriber'] );
	$input->setTds2WorkPhoneCC( $_POST['Tds2WorkPhoneCC'] );
	$input->setTds2WorkPhoneSubscriber( $_POST['Tds2WorkPhoneSubscriber'] );
	$input->setTds2ShipAddrCity( $_POST['Tds2ShipAddrCity'] );
	$input->setTds2ShipAddrCountry( $_POST['Tds2ShipAddrCountry'] );
	$input->setTds2ShipAddrLine1( $_POST['Tds2ShipAddrLine1'] );
	$input->setTds2ShipAddrLine2( $_POST['Tds2ShipAddrLine2'] );
	$input->setTds2ShipAddrLine3( $_POST['Tds2ShipAddrLine3'] );
	$input->setTds2ShipAddrPostCode( $_POST['Tds2ShipAddrPostCode'] );
	$input->setTds2ShipAddrState( $_POST['Tds2ShipAddrState'] );
	$input->setTds2DeliveryEmailAddress( $_POST['Tds2DeliveryEmailAddress'] );
	$input->setTds2DeliveryTimeframe( $_POST['Tds2DeliveryTimeframe'] );
	$input->setTds2GiftCardAmount( $_POST['Tds2GiftCardAmount'] );
	$input->setTds2GiftCardCount( $_POST['Tds2GiftCardCount'] );
	$input->setTds2GiftCardCurr( $_POST['Tds2GiftCardCurr'] );
	$input->setTds2PreOrderDate( $_POST['Tds2PreOrderDate'] );
	$input->setTds2PreOrderPurchaseInd( $_POST['Tds2PreOrderPurchaseInd'] );
	$input->setTds2ReorderItemsInd( $_POST['Tds2ReorderItemsInd'] );
	$input->setTds2ShipInd( $_POST['Tds2ShipInd'] );
	$input->setTds2RecurringExpiry( $_POST['Tds2RecurringExpiry'] );
	$input->setTds2RecurringFrequency( $_POST['Tds2RecurringFrequency'] );
	$input->setRetUrl( $_POST['RetUrl'] );

	//API通信クラスをインスタンス化します
	$exe = new ExecTran();/* @var $exec ExecTran */

	//パラメータオブジェクトを引数に、実行メソッドを呼びます。
	//正常に終了した場合、結果オブジェクトが返るはずです。
	$output = $exe->exec( $input );/* @var $output ExecTranOutput */

	//実行後、その結果を確認します。

	if( $exe->isExceptionOccured() ){//取引の処理そのものがうまくいかない（通信エラー等）場合、例外が発生します。

		//サンプルでは、例外メッセージを表示して終了します。
		require_once( PGCARD_SAMPLE_BASE . 'display/Exception.php');
		exit();

	}else{

		//例外が発生していない場合、出力パラメータオブジェクトが戻ります。

		if( $output->isErrorOccurred() ){//出力パラメータにエラーコードが含まれていないか、チェックしています。

			//サンプルでは、エラーが発生していた場合、エラー画面を表示して終了します。
			require_once( PGCARD_SAMPLE_BASE . 'display/Error.php');
			exit();

		}else if( $output->isTdSecure() ){//決済実行の場合、3Dセキュアフラグをチェックします。

			//3Dセキュアフラグがオンである場合、リダイレクトページを表示する必要があります。
			//サンプルでは、モジュールタイプに標準添付されるリダイレクトユーティリティを利用しています。

			//リダイレクト用パラメータをインスタンス化して、パラメータを設定します
			require_once( 'input/AcsParam.php');
			require_once( 'common/RedirectUtil.php');
			$redirectInput = new AcsParam();
			$redirectInput->setAcsUrl( $output->getAcsUrl() );
			$redirectInput->setMd( $_POST['AccessID'] );
			$redirectInput->setPaReq( $output->getPaReq() );
			$redirectInput->setTermUrl( PGCARD_SAMPLE_URL . '/SecureTran.php');

			//リダイレクトページ表示クラスをインスタンス化して実行します。
			$redirectShow = new RedirectUtil();
			print ($redirectShow->createRedirectPage( PGCARD_SECURE_RIDIRECT_HTML , $redirectInput ) );
			exit();

		}else if( $output->isTdSecure2() ){//決済実行の場合、3Dセキュアフラグをチェックします。

		    //3Dセキュアフラグがオンである場合、リダイレクトページを表示する必要があります。
		    //サンプルでは、モジュールタイプに標準添付されるリダイレクトユーティリティを利用しています。

		    require_once( 'common/RedirectUtil.php');
		    $redirectShow = new RedirectUtil();
		    print ($redirectShow->createSecure2RedirectPage( PGCARD_SECURE2_RIDIRECT_HTML , $output->getRedirectUrl() ) );

			exit();
		}

		//例外発生せず、エラーの戻りもなく、3Dセキュアフラグもオフであるので、実行結果を表示します。
	}

}

//ExecTran入力・結果画面
require_once( PGCARD_SAMPLE_BASE . '/display/ExecTran.php' );