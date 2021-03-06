function list4PO(enFunc, txt2Query, inpTxtName, extQuery) {
    if (enFunc === 1) {
        // console.log('enFunc : ' + enFunc);
        return;
    }
    if (enFunc === 2) {
        console.log('enFunc : ' + enFunc);
        console.log('text2query : ' + txt2Query);
        console.log('input text name : ' + inpTxtName);
        console.log('ext query : ' + extQuery);
        let suppName = '';
        if (extQuery === 'wg_suppcode') {
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
            "wg_ponum",
            "wg_vlpn",
            "wg_suppcode"
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
}

function chkAvailableVLPN(lpn2Check) {
    let chkResult = document.getElementById("VLPNCheckResult");
    //console.log('lpn to check ' + lpn2Check);
    if (lpn2Check !== '') {
        queryData("php4PO.php?command=checkVLPN&vlpn=" + lpn2Check);
        {
            if (xhr_object.responseText === '1') {
                chkResult.style.color = "red";
                chkResult.innerHTML = "&nbsp;(??????????????????????????? " + lpn2Check + " ????????????????????????????????????????????????)";
            } else {
                chkResult.style.color = "green";
                chkResult.innerHTML = "&nbsp;(??????????????????????????? " + lpn2Check + " ?????????????????????????????????)";
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