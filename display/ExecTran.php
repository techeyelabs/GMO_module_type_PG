<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="ja-JP" xml:lang="ja-JP">
<head>
	<meta http-equiv="Content-Style-Type" content="text/css; charset=UTF-8" />
	<link rel="stylesheet" href="style/pgcommon.css" charset="UTF-8" />

	<title>[Exec]-PGマルチペイメントサービス－モジュールタイプ呼び出しサンプル</title>
</head>
<body>

<div id="header">
	<h1>決済実行/モジュールタイプ(PHP) 呼び出しサンプル</h1>
	<a href="index.html">インデックスに戻る</a>
</div>

<div id="main">
	<?php
		 if( !isset ($_POST['submit']) ){//初期表示です
	?>
	<form action="<?php echo $_SERVER['REQUEST_URI'] ?>" method="post">
		<table>
			<tbody>
				<tr>
					<th scope="row">取引ID(AccessID)</th>
					<td><input name="AccessID" type="text" value="<?php echo isset($_GET['AccessID'])? $_GET['AccessID'] : '' ?>" tabindex="11" /></td>
				</tr>
				<tr>
					<th scope="row">取引パスワード(AccessPass)</th>
					<td><input name="AccessPass" type="text" value="<?php echo isset($_GET['AccessPass'])? $_GET['AccessPass'] : '' ?>" tabindex="12" /></td>
				</tr>
				<tr>
					<th scope="row">オーダーID(OrderID)</th>
					<td><input name="OrderID" type="text" maxlength="27" value="<?php echo isset($_GET['OrderID'])? $_GET['OrderID'] : '' ?>" tabindex="13" /></td>
				</tr>
				<tr>
					<th scope="row">支払方法(PayMethod)</th>
					<td>
						<select name="PayMethod" tabindex="14">
							<option value="1">1:一括</option>
							<option value="2">2:分割</option>
							<option value="3">3:ボーナス一括</option>
							<option value="4">4:ボーナス分割</option>
							<option value="5">5:リボ</option>
						</select>
					</td>
				</tr>
				<tr>
					<th scope="row">支払回数(PayTimes)</th>
					<td><input name="PayTimes" type="text" maxlength="3" class="num" size="5" tabindex="15" /></td>
				</tr>
				<tr>
					<th scope="row">加盟店自由項目１(ClientField1)</th>
					<td><input name="ClientField1" type="text" maxlength="100" tabindex="16" /> </td>
				</tr>
				<tr>
					<th scope="row">加盟店自由項目２(ClientField2)</th>
					<td><input name="ClientField2" type="text" maxlength="100" tabindex="17" /> </td>
				</tr>
				<tr>
					<th scope="row">加盟店自由項目３(ClientField3)</th>
					<td><input name="ClientField3" type="text" maxlength="100" tabindex="18" /> </td>
				</tr>
				<tr>
					<th scope="row">利用明細に記載される文言(DisplayInfo)</th>
					<td><input name="DisplayInfo" type="text" maxlength="100" tabindex="19" /> </td>
				</tr>
			</tbody>
		</table>

		<table>
			<caption>カード番号入力型決済の場合、この欄を入力</caption>
			<tbody>
			<tr>
				<th scope="row">カード番号(CardNo)</th>
				<td><input name="CardNo" type="text" maxlength="16" size="20" tabindex="19"/></td>
			</tr>
			<tr>
				<th scope="row">カード有効期限YYMM(Expire)</th>
				<td><input name="Expire" type="text" maxlength="4" size="5" tabindex="20" /></td>
			</tr>
			<tr>
				<th scope="row">セキュリティコード(SecurityCode)</th>
				<td><input name="SecurityCode" type="text" maxlength="4" size="5" tabindex="21" /></td>
			</tr>
			</tbody>
		</table>

		<table>
			<caption>会員ID型決済の場合、この欄を入力</caption>
			<tbody>
				<tr>
					<th scope="row">会員ID(MemberID)</th>
					<td><input name="MemberID" type="text" maxlength="60" size="30" tabindex="22" /></td>
				</tr>
				<tr>
					<th scope="row">登録カード連番(CardSeq)</th>
					<td><input name="CardSeq" type="text" maxlength="1" class="num" size="5" tabindex="23" /></td>
				</tr>
			</tbody>
		</table>

		<table>
			<caption>トークン方式の場合、この欄を入力</caption>
			<tbody>
			<tr>
				<th scope="row">トークンタイプ(TokenType)</th>
				<td>
					<select name="TokenType" tabindex="24">
						<option value="">無指定(カード情報トークン化サービス)</option>
						<option value="1" selected="selected">1:カード情報トークン化サービス</option>
						<option value="2">2:Google Payment token</option>
					</select>
				</td>
			</tr>
			<tr>
				<th scope="row">トークン(Token)</th>
				<td><input name="Token" type="text" maxlength="512" size="50" tabindex="25"/></td>
			</tr>
			</tbody>
		</table>

		<table>
			<caption>3DS2.0を利用する場合、この欄を入力</caption>
				<tr>
					<th scope="row">カード会員最終更新日YYYYMMDD(Tds2ChAccChange)</th>
					<td><input name="Tds2ChAccChange" type="text" maxlength="8" size="10" tabindex="26" /> </td>
				</tr>
				<tr>
					<th scope="row">カード会員作成日YYYYMMDD(Tds2ChAccDate)</th>
					<td><input name="Tds2ChAccDate" type="text" maxlength="8" size="10" tabindex="27" /> </td>
				</tr>
				<tr>
					<th scope="row">カード会員パスワード変更日YYYYMMDD(Tds2ChAccPwChange)</th>
					<td><input name="Tds2ChAccPwChange" type="text" maxlength="8" size="10" tabindex="28" /> </td>
				</tr>
				<tr>
					<th scope="row">過去6ヶ月間の購入回数(Tds2NbPurchaseAccount)</th>
					<td><input name="Tds2NbPurchaseAccount" type="text" maxlength="4" size="5" tabindex="29" class="num" /> </td>
				</tr>
				<tr>
					<th scope="row">カード登録日YYYYMMDD(Tds2PaymentAccAge)</th>
					<td><input name="Tds2PaymentAccAge" type="text" maxlength="8" size="10" tabindex="30" /> </td>
				</tr>
				<tr>
					<th scope="row">過去24時間のカード追加の試行回数(Tds2ProvisionAttemptsDay)</th>
					<td><input name="Tds2ProvisionAttemptsDay" type="text" maxlength="8" size="10" tabindex="31" class="num" /> </td>
				</tr>
				<tr>
					<th scope="row">配送先住所の初回使用日YYYYMMDD(Tds2ShipAddressUsage)</th>
					<td><input name="Tds2ShipAddressUsage" type="text" maxlength="8" size="10" tabindex="32"/> </td>
				</tr>
				<tr>
					<th scope="row">3DS2.0非対応時の対応種別(Tds2ShipNameInd)</th>
					<td>
						<select name="Tds2ShipNameInd" tabindex="33">
							<option value="">無指定</option>
							<option value="01">01：カード会員名と配送先名が一致</option>
							<option value="02">02：カード会員名と配送先名が不一致</option>
						</select>
					</td>
				</tr>
				<tr>
					<th scope="row">カード会員の不審行為情報(Tds2SuspiciousAccActivity)</th>
					<td>
						<select name="Tds2SuspiciousAccActivity" tabindex="34">
							<option value="">無指定</option>
							<option value="01">01：不審な行動は見られなかった</option>
							<option value="02">02：不審な行動が見られた</option>
						</select>
					</td>
				</tr>
				<tr>
					<th scope="row">過去24時間の取引回数(Tds2TxnActivityDay)</th>
					<td><input name="Tds2TxnActivityDay" type="text" maxlength="3" size="5" tabindex="35"  class="num"/> </td>
				</tr>
				<tr>
					<th scope="row">前年の取引回数(Tds2TxnActivityYear)</th>
					<td><input name="Tds2TxnActivityYear" type="text" maxlength="3" size="5" tabindex="36"  class="num"/> </td>
				</tr>
				<tr>
					<th scope="row">ログイン証跡(Tds2ThreeDSReqAuthData)</th>
					<td><input name="Tds2ThreeDSReqAuthData" type="text" maxlength="2048" tabindex="37"/> </td>
				</tr>
				<tr>
					<th scope="row">ログイン方法(Tds2ThreeDSReqAuthMethod)</th>
					<td>
						<select name="Tds2ThreeDSReqAuthMethod" tabindex="38">
							<option value="">無指定</option>
							<option value="01">01：3DSリクエスター認証が行われなかった（つまり、カード会員がゲストとして「ログイン」した）</option>
							<option value="02">02：3DSリクエスター自身の認証情報を利用した3DSリクエスターシステム上のカード会員アカウントへのログイン</option>
							<option value="03">03：連合IDを利用した3DSリクエスターシステム上のカード会員アカウントへのログイン</option>
							<option value="04">04：イシュアーの認証情報を利用した3DSリクエスターシステム上のカード会員アカウントへのログイン</option>
							<option value="05">05：サードパーティ認証を利用した3DSリクエスターシステム上のカード会員アカウントへのログイン</option>
							<option value="06">06：FIDOオーセンティケーターを利用した3DSリクエスターシステム上のアカウントへのログイン</option>
						</select>
					</td>
				</tr>
				<tr>
					<th scope="row">ログイン日時YYYYMMDDHHMM(Tds2ThreeDSReqAuthTimestamp)</th>
					<td><input name="Tds2ThreeDSReqAuthTimestamp" type="text" maxlength="12" size="10" tabindex="39"/> </td>
				</tr>
				<tr>
					<th scope="row">請求先住所と配送先住所の一致/不一致(Tds2AddrMatch)</th>
					<td>
						<select name="Tds2AddrMatch" tabindex="40">
							<option value="">無指定</option>
							<option value="Y">Y：一致</option>
							<option value="N">N：不一致</option>
						</select>
					</td>
				</tr>
				<tr>
					<th scope="row">請求先住所の都市(Tds2BillAddrCity)</th>
					<td><input name="Tds2BillAddrCity" type="text" maxlength="50" tabindex="41"/> </td>
				</tr>
				<tr>
					<th scope="row">請求先住所の国番号(Tds2BillAddrCountry)</th>
					<td><input name="Tds2BillAddrCountry" type="text" maxlength="3" size="5" tabindex="42"/> </td>
				</tr>
				<tr>
					<th scope="row">請求先住所の区域部分の１行目(Tds2BillAddrLine1)</th>
					<td><input name="Tds2BillAddrLine1" type="text" maxlength="50" tabindex="43"/> </td>
				</tr>
				<tr>
					<th scope="row">請求先住所の区域部分の２行目(Tds2BillAddrLine2)</th>
					<td><input name="Tds2BillAddrLine2" type="text" maxlength="50" tabindex="44"/> </td>
				</tr>
				<tr>
					<th scope="row">請求先住所の区域部分の３行目(Tds2BillAddrLine3)</th>
					<td><input name="Tds2BillAddrLine3" type="text" maxlength="50" tabindex="45"/> </td>
				</tr>
				<tr>
					<th scope="row">請求先住所の郵便番号(Tds2BillAddrPostCode)</th>
					<td><input name="Tds2BillAddrPostCode" type="text" maxlength="16" tabindex="46"/> </td>
				</tr>
				<tr>
					<th scope="row">請求先住所の州または都道府県番号(Tds2BillAddrState)</th>
					<td><input name="Tds2BillAddrState" type="text" maxlength="3" size="5" tabindex="47"/> </td>
				</tr>
				<tr>
					<th scope="row">カード会員のメールアドレス(Tds2Email)</th>
					<td><input name="Tds2Email" type="text" maxlength="254" tabindex="48"/> </td>
				</tr>
				<tr>
					<th scope="row">自宅電話の国コード(Tds2HomePhoneCC)</th>
					<td><input name="Tds2HomePhoneCC" type="text" maxlength="3" size="5" tabindex="49"/> </td>
				</tr>
				<tr>
					<th scope="row">自宅電話番号(Tds2HomePhoneSubscriber)</th>
					<td><input name="Tds2HomePhoneSubscriber" type="text" maxlength="15" size="10" tabindex="50"/> </td>
				</tr>
				<tr>
					<th scope="row">携帯電話の国コード(Tds2MobilePhoneCC)</th>
					<td><input name="Tds2MobilePhoneCC" type="text" maxlength="3" size="5" tabindex="51"/> </td>
				</tr>
				<tr>
					<th scope="row">携帯電話番号(Tds2MobilePhoneSubscriber)</th>
					<td><input name="Tds2MobilePhoneSubscriber" type="text" maxlength="15" size="52" tabindex="50"/> </td>
				</tr>
				<tr>
					<th scope="row">職場電話の国コード(Tds2WorkPhoneCC)</th>
					<td><input name="Tds2WorkPhoneCC" type="text" maxlength="3" size="5" tabindex="53"/> </td>
				</tr>
				<tr>
					<th scope="row">職場電話番号(Tds2WorkPhoneSubscriber)</th>
					<td><input name="Tds2WorkPhoneSubscriber" type="text" maxlength="15" size="10" tabindex="54"/> </td>
				</tr>
				<tr>
					<th scope="row">配送先住所の都市(Tds2ShipAddrCity)</th>
					<td><input name="Tds2ShipAddrCity" type="text" maxlength="50" tabindex="55"/> </td>
				</tr>
				<tr>
					<th scope="row">配送先住所の国番号(Tds2ShipAddrCountry)</th>
					<td><input name="Tds2ShipAddrCountry" type="text" maxlength="3" size="5" tabindex="56"/> </td>
				</tr>
				<tr>
					<th scope="row">配送先住所の区域部分の１行目(Tds2ShipAddrLine1)</th>
					<td><input name="Tds2ShipAddrLine1" type="text" maxlength="50" tabindex="57"/> </td>
				</tr>
				<tr>
					<th scope="row">配送先住所の区域部分の２行目(Tds2ShipAddrLine2)</th>
					<td><input name="Tds2ShipAddrLine2" type="text" maxlength="50" tabindex="58"/> </td>
				</tr>
				<tr>
					<th scope="row">配送先住所の区域部分の３行目(Tds2ShipAddrLine3)</th>
					<td><input name="Tds2ShipAddrLine3" type="text" maxlength="50" tabindex="59"/> </td>
				</tr>
				<tr>
					<th scope="row">配送先住所の郵便番号(Tds2ShipAddrPostCode)</th>
					<td><input name="Tds2ShipAddrPostCode" type="text" maxlength="16" tabindex="60"/> </td>
				</tr>
				<tr>
					<th scope="row">配送先住所の州または都道府県番号(Tds2ShipAddrState)</th>
					<td><input name="Tds2ShipAddrState" type="text" maxlength="3" size="5" tabindex="61"/> </td>
				</tr>
				<tr>
					<th scope="row">納品先電子メールアドレス(Tds2DeliveryEmailAddress)</th>
					<td><input name="Tds2DeliveryEmailAddress" type="text" maxlength="254" tabindex="62"/> </td>
				</tr>
				<tr>
					<th scope="row">商品納品時間枠(Tds2DeliveryTimeframe)</th>
					<td>
						<select name="Tds2DeliveryTimeframe" tabindex="63">
							<option value="">無指定</option>
							<option value="01">01：電子デリバリー</option>
							<option value="02">02：当日出荷</option>
							<option value="03">03：翌日出荷</option>
							<option value="04">04：2日目以降の出荷</option>
						</select>
					</td>
				</tr>
				<tr>
					<th scope="row">プリペイドカードまたはギフトカードの総購入金額(Tds2GiftCardAmount)</th>
					<td><input name="Tds2GiftCardAmount" type="text" maxlength="15" size="10" tabindex="64"/> </td>
				</tr>
				<tr>
					<th scope="row">購入されたプリペイドカードまたはギフトカード の総数(Tds2GiftCardCount)</th>
					<td><input name="Tds2GiftCardCount" type="text" maxlength="2" size="5" tabindex="65"/> </td>
				</tr>
				<tr>
					<th scope="row">購入されたプリペイドカードまたはギフトカードの通貨コード(Tds2GiftCardCurr)</th>
					<td><input name="Tds2GiftCardCurr" type="text" maxlength="3" size="5" tabindex="66"/> </td>
				</tr>
				<tr>
					<th scope="row">商品の発売予定日YYYYMMDD(Tds2PreOrderDate)</th>
					<td><input name="Tds2PreOrderDate" type="text" maxlength="8" size="10" tabindex="67"/> </td>
				</tr>
				<tr>
					<th scope="row">商品の販売時期情報(Tds2PreOrderPurchaseInd)</th>
					<td>
						<select name="Tds2PreOrderPurchaseInd" tabindex="68">
							<option value="">無指定</option>
							<option value="01">01 = 発売済み商品</option>
							<option value="02">02 = 先行予約商品</option>
						</select>
					</td>
				</tr>
				<tr>
					<th scope="row">商品の注文情報(Tds2ReorderItemsInd)</th>
					<td>
						<select name="Tds2ReorderItemsInd" tabindex="69">
							<option value="">無指定</option>
							<option value="01">01 = 初回注文</option>
							<option value="02">02 = 再注文</option>
						</select>
					</td>
				</tr>
				<tr>
					<th scope="row">取引の配送方法(Tds2ShipInd)</th>
					<td>
						<select name="Tds2ShipInd" tabindex="70">
							<option value="">無指定</option>
							<option value="01">01 = カード会員の請求先住所に配送する</option>
							<option value="02">02 = 加盟店様が保持している別の、確認済み住所に配送する</option>
							<option value="03">03 = カード会員の請求先住所と異なる住所に配送する</option>
							<option value="04">04 = 店舗へ配送 / 近所の店舗での受け取り（店舗の住所は配送先住所で指定する）</option>
							<option value="05">05 = デジタル商品（オンラインサービス、電子ギフトカードおよび償還コードを含む）</option>
							<option value="06">06 = 配送なし（旅行およびイベントのチケット）</option>
							<option value="07">07 = その他（ゲーム、配送されないデジタルサービス、電子メディアの購読料など）</option>
						</select>
					</td>
				</tr>
				<tr>
					<th scope="row">継続課金の期限YYYYMMDD(Tds2RecurringExpiry)</th>
					<td><input name="Tds2RecurringExpiry" type="text" maxlength="8" size="10" tabindex="71"/> </td>
				</tr>
				<tr>
					<th scope="row">継続課金の課金最小間隔日数(Tds2RecurringFrequency)</th>
					<td><input name="Tds2RecurringFrequency" type="text" maxlength="4" size="5" tabindex="72"/> </td>
				</tr>
				<tr>
					<th scope="row">加盟店戻りURL(RetUrl)</th>
					<td><input name="RetUrl" type="text" maxlength="256" tabindex="73"/> </td>
				</tr>
		</table>
		<input name="submit" type="submit" value="実行"  tabindex="74" />
	</form>
	<?php
		}else{//送信結果の表示です
			// $my_file = 'final_output.txt';
			// $handle = fopen($my_file, 'w') or die('Cannot open file:  '.$my_file);
			// $data = 'This is the data';
			// fwrite($handle, $output->getSecureFlag());
			// var_dump($output->getApprovalNo());
			// exit;
	?>
		<table>
			<caption>実行結果</caption>
			<tfoot>
				 <tr>
				 	<td colspan="2"><a href="TradedCard.php?<?php echo 'OrderID=' . $output->getOrderId() . '&MemberID=' . $memberId ; ?>" tabindex="25">今使ったカードを登録</a></td>
				 </tr>
			</tfoot>
			<tbody>
				<tr>
					<th scope="row">ACS呼出判定(ACS)</th>
					<td><?php echo $output->getSecureFlag() ?></td>
				</tr>
				<tr>
					<th scope="row">オーダーID(OrderID)</th>
					<td><?php echo $output->getOrderId() ?></td>
				</tr>
				<tr>
					<th scope="row">仕向先カード会社(Forward)</th>
					<td><?php echo $output->getForward() ?></td>
				</tr>
				<tr>
					<th scope="row">支払方法(Method)</th>
					<td><?php echo $output->getMethod() ?></td>
				</tr>
				<tr>
					<th scope="row">支払回数(PayTimes)</th>
					<td><?php echo $output->getPayTimes() ?></td>
				</tr>
				<tr>
					<th scope="row">承認番号(Approve)</th>
					<td><?php echo $output->getApprovalNo() ?></td>
				</tr>
				<tr>
					<th scope="row">トランザクションID(TranID)</th>
					<td><?php echo $output->getTranId() ?></td>
				</tr>
				<tr>
					<th scope="row">決済日付(TranDate)</th>
					<td><?php echo $output->getTranDate() ?></td>
				</tr>
				<tr>
					<th scope="row">チェック文字列(CheckString)</th>
					<td><?php echo $output->getCheckString() ?></td>
				</tr>
				<tr>
					<th scope="row">加盟店自由項目１(ClientField1)</th>
					<td><?php echo htmlspecialchars( mb_convert_encoding( $output->getClientField1() , PGCARD_SAMPLE_ENCODING , 'SJIS') ) ?></td>
				</tr>
				<tr>
					<th scope="row">加盟店自由項目２(ClientField2)</th>
					<td><?php echo htmlspecialchars( mb_convert_encoding( $output->getClientField2() , PGCARD_SAMPLE_ENCODING , 'SJIS') ) ?></td>
				</tr>
				<tr>
					<th scope="row">加盟店自由項目３(ClientField3)</th>
					<td><?php echo htmlspecialchars( mb_convert_encoding( $output->getClientField3() , PGCARD_SAMPLE_ENCODING , 'SJIS') ) ?></td>
				</tr>
				<tr>
					<th scope="row">ActiveServerへのリダイレクトURL(RedirectUrl)</th>
					<td><?php echo $output->getRedirectUrl() ?></td>
				</tr>
			</tbody>
		</table>
	<?php
		}//if( !isset ($_POST['submit']) )
	?>
</div>

<div id="footer">
	<em>Copyright (c) GMO Payment Gateway,Inc. All Rights Reserved.</em>
</div>


</body>
</html>