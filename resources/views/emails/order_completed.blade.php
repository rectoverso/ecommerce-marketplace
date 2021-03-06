@extends('emails._main')

@section('mail')
        <body>
            <center>
                <table align="center" border="0" cellpadding="-20px" cellspacing="0" height="0%" width="100%" id="bodyTable">
                    <tr>
                                    <td align="center" valign="top" id="templateHeader">
                                        <!--[if gte mso 9]>
                                        <table align="center" border="0" cellspacing="0" cellpadding="0" width="600" style="width:600px;">
                                        <tr>
                                        <td align="center" valign="top" width="600" style="width:600px;">
                                        <![endif]-->
                                        <table align="center" border="0" cellpadding="0" cellspacing="0" width="100%" class="templateContainer">
                                            <tr>
                                                <td valign="top" class="headerContainer"><table class="mcnImageBlock" style="min-width:100%;" border="0" cellpadding="0" cellspacing="0" width="100%">
        <tbody class="mcnImageBlockOuter">
                <tr>
                    <td style="padding:0px" class="mcnImageBlockInner" valign="top">
                        <table class="mcnImageContentContainer" style="min-width:100%;" align="left" border="0" cellpadding="0" cellspacing="0" width="100%">
                            <tbody><tr>
                                <td class="mcnImageContent" style="padding-right: 9px; padding-left: 9px; padding-top: 10px; padding-bottom: 10px; text-align:center;" valign="top">
                                    
                                        
                                            <img alt="" src="https://gallery.mailchimp.com/0703726b93d229eadd93c6ffc/images/d8321ab1-d37f-4f06-98ba-5bede53e02db.png" style="max-width:151px; padding-bottom: 0; display: inline !important; vertical-align: bottom;" class="mcnImage" align="middle" width="151">
                                        
                                    
                                </td>
                            </tr>
                        </tbody></table>
                    </td>
                </tr>
        </tbody>
    </table><table class="mcnImageBlock" style="min-width:100%;" border="0" cellpadding="0" cellspacing="0" width="100%">
        <tbody class="mcnImageBlockOuter">
                <tr>
                    <td style="padding:0px" class="mcnImageBlockInner" valign="top">
                        <table class="mcnImageContentContainer" style="min-width:100%;" align="left" border="0" cellpadding="0" cellspacing="0" width="100%">
                            <tbody><tr>
                                <td class="mcnImageContent" style="padding-right: 0px; padding-left: 0px; padding-top: 0; padding-bottom: 0; text-align:center;" valign="top">
                                    
                                        
                                            <img alt="" src="https://gallery.mailchimp.com/0703726b93d229eadd93c6ffc/images/51a7ca98-4678-4f62-bf26-a8e24d0078dc.jpg" style="max-width:940px; padding-bottom: 0; display: inline !important; vertical-align: bottom;" class="mcnImage" align="middle" width="600">
                                        
                                    
                                </td>
                            </tr>
                        </tbody></table>
                    </td>
                </tr>
        </tbody>
    </table><table class="mcnBoxedTextBlock" border="0" cellpadding="0" cellspacing="0" style="width: 600px; margin: 0 auto;">
        <!--[if gte mso 9]>
        <table align="center" border="0" cellspacing="0" cellpadding="0" width="100%">
        <![endif]-->
        <tbody class="mcnBoxedTextBlockOuter">
            <tr>
                <td class="mcnBoxedTextBlockInner" valign="top">
                    
                    <!--[if gte mso 9]>
                    <td align="center" valign="top" ">
                    <![endif]-->
                    <table style="min-width:100%;" class="mcnBoxedTextContentContainer" align="left" border="0" cellpadding="0" cellspacing="0" width="100%">
                        <tbody><tr>
                            
                            <td style="padding-top:0px; padding-left:0px; padding-bottom:0px; padding-right:0px;">
                            
                                <table class="mcnTextContentContainer" style="min-width: 100% ! important;background-color: #2480A5;" border="0" cellpadding="18" cellspacing="0" width="100%">
                                    <tbody><tr>
                                        <td style="color: #F2F2F2;font-family: Helvetica;font-size: 14px;font-weight: bold;text-align: left;" class="mcnTextContent" valign="top">
                                            <span style="font-size:15px"><span style="font-family:trebuchet ms,lucida grande,lucida sans unicode,lucida sans,tahoma,sans-serif">
    Thank you for your order!<br>
    Here is your receipt:<br><br>
    <table>
        <thead>
            <tr>
                <th>Order Number</th>
                <th>Collection Time</th>
                <th>Coffee Shop</th>
                <th>Location</th>
                <th>Post Code</th>
            </tr>
        </thead>
        <tr>
            <td>{{ $order->id }}</td>
            <td>@if ($order->pickup_time == '00:00:00') Make On Arrival @else {{ $order->pickup_time }} @endif</td>
            <td>{{ $order->coffee_shop->name }}</td>
            <td>{{$order->coffee_shop->location }}</td>
            <td>{{ $order->coffee_shop->postal_code }}</td>
        </tr>
    </table>
    <table>
        <thead>
        <tr>
            <th>Your order</th>
            <th>Total: £{{ number_format($order->price / 100, 2, '.', ',') }}</th>
        </tr>
        </thead>
        @foreach($order->order_lines as $line)
            <tr>
                <td>
                    {{$line->product->type == 'drink' ? $coffeeShop->getSizeDisplayName($line->size) : ''}}
                    {{$coffeeShop->getNameFor($line->product)}}
                </td>
                <td>£{{ number_format($line->price / 100, 2, '.', ',') }}</td>
            </tr>
        @endforeach
            <tr>
                <td>Processing Fee:</td>
                <td>20p</td>
            </tr>
    </table>
@stop
