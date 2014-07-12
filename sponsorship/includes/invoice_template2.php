<table width="100%">
    <tr>
        <td width="80" align="left" valign="top" nowrap >
            <p><strong>Registrant:</strong> </p>
        </td>
        <td rowspan="2" nowrap>
            <p>{fname} {lname}<br>
                {company}<br>
                {full_address}</p>
        </td>
        <td width="116" align="right" valign="top" nowrap >
            <p><strong> Invoice #:&nbsp; </strong> </p>
        </td>
        <td width="151" valign="top" nowrap >
            <p>BPS-{sid} </p>
        </td>
    </tr>
    <tr>
        <td>
            <p>&nbsp;&nbsp;</p>
        </td>
        <td align="right" valign="top" nowrap >
            <p><strong>Date:</strong>&nbsp;</p>
        </td>
        <td valign="top" nowrap >
            <p>{date}</p>
        </td>
    </tr>

<!--    {billing_info}-->
</table>
<table width="100%" border="0" cellpadding="0" cellspacing="0" id="totaling">
    <tr>
        <td width="20">&nbsp; </td>
        <td>&nbsp; <!--{special_notes}--></td>
        <td width="60" align="center">			</td>
        <td width="77" align="right"> 
            <p><strong>Amount</strong> </p>			</td>
    </tr>
    {invoice_details}
    <tr>
        <td colspan="3" align="right">
            <h3>Sub Total:</h3>		</td>
        <td align="right"> 
            <h3>{totalcharged}</h3>			</td>
    </tr>
<!--    <tr>
        <td colspan="3" align="right"><p><strong>GST:</strong></p></td>
        <td align="right"><p>{gstcharged}</p></td>
    </tr>-->

    {paymenthistory}

    <tr>
        <td colspan="3" align="right" class="{message_status}">
            <h3>{totaldue_message} </h3>			</td>
        <td align="right" class="{message_status}">
            <h3>{totaldue}</h3>			</td>
    </tr>
<!--    <tr>
        <td colspan="4" align="right"><p><em><strong>All prices  are in Canadian Funds.</strong></em></p>
            <p>GST# 13745 8360 RT0001			</p>
            <p class="small">&nbsp;</p></td>
    </tr>-->
</table>
{refund_message}
