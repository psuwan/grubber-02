function list4PO(txt2Query, inpTxtName, extQuery) {
    let suppName = '';
    if (extQuery === 'po_suppcode') {
        suppName = txt2Query.split(" ");
        txt2Query = suppName[0];
    }

    let arrInpTxt = [
        "id4PONumber",
        "id4VlpnNumber",
        "id4POSuppName"
    ];
    let poDetails = arrInpTxt.filter(function (e) {
        return e != "id4" + inpTxtName;
    });

    let arrShow2InpTxt = [
        "po_number",
        "po_vlpn",
        "po_suppcode"
    ];
    let inpTxt2show = arrShow2InpTxt.filter(function (e) {
        return e != extQuery;
    });

    if (txt2Query != "") {
        queryData(
            "php4PO.php?command=query4po&field2Query=" +
            inpTxtName +
            "&fieldReturn=" +
            extQuery +
            "&field2Show=" +
            inpTxt2show[0] +
            "&fieldValue=" +
            escape(txt2Query)
        );
        {
            document.getElementById(poDetails[0]).value = xhr_object.responseText;
        }
        queryData(
            "php4PO.php?command=query4po&field2Query=" +
            inpTxtName +
            "&fieldReturn=" +
            extQuery +
            "&field2Show=" +
            inpTxt2show[1] +
            "&fieldValue=" +
            escape(txt2Query)
        );
        {
            document.getElementById(poDetails[1]).value = xhr_object.responseText;
        }
    }
}

function chkAvailableVLPN(lpn2Check) {
    let chkResult = document.getElementById("chkresult");
    console.log('lpn to check ' + lpn2Check);
    if (lpn2Check !== '') {
        queryData("php4PO.php?command=checkVLPN&vlpn=" + lpn2Check);
        {
            if (xhr_object.responseText === '1') {
                chkResult.style.color = "red";
                chkResult.innerHTML = "&nbsp;(รถทะเบียน " + lpn2Check + " ยังไม่ปิดการซื้อ)";
            } else {
                chkResult.style.color = "green";
                chkResult.innerHTML = "&nbsp;(รถทะเบียน " + lpn2Check + " ชั่งเข้าได้)";
            }
        }
    } else {
        chkResult.innerHTML = "";
    }
}

function queryData(URL) {
    if (window.XMLHttpRequest) {
        xhr_object = new XMLHttpRequest();
    } else if (window.ActiveXObject) {
        xhr_object = new ActiveXObject("Microsoft.XMLHTTP");
    } else {
        return false;
    }

    xhr_object.open("GET", URL, false);
    xhr_object.send(null);

    if (xhr_object.readyState === 4) {
        return xhr_object.responseText;
    } else {
        return false;
    }
}