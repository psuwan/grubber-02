/*
202109080928 FUNCTION TO RETURN WEIGHT IN SELL ORDER (OK)
PASS PARAMETER SONUMBER AND LOCATION TO DISPLAY VALUE
*/
function getWg4SO(soNumberWithName, loc2Disp) {
    let soNumber = soNumberWithName.split(" / ");
    let wgFromSO = '';
    queryData("php4SO.php?command=getWeight4SO&soNumber=" + soNumber[0]);
    {
        wgFromSO = xhr_object.responseText;
        $("#" + loc2Disp).addClass("text-primary");
        document.getElementById(loc2Disp).style.textAlign = "right";
        document.getElementById(loc2Disp).value = wgFromSO.replace(/\B(?=(\d{3})+(?!\d))/g, ",") + ".00 กก.";
    }
}/* 202109080928 FUNCTION TO RETURN WEIGHT IN SELL ORDER (OK) */

/* 20210908162500 FUNCTION TO RETURN SO-NUMBER FOR SUPPLIER LOGISTIC */
function getSONumber4SuppLogis(code4SuppLogis, loc2Disp) {
    let suppLogis = code4SuppLogis.split(" / ");
    console.log(suppLogis[0]);
    queryData("php4SO.php?command=getSONumber4SuppLogis&code4SuppLogis=" + suppLogis[0]);
    {
        console.log(xhr_object.responseText);
        // $("#" + loc2Disp).addClass("text-primary");
        document.getElementById(loc2Disp).value = xhr_object.responseText;
    }
}/* 20210908162500 FUNCTION TO RETURN SO-NUMBER FOR SUPPLIER LOGISTIC */

// FUNCTION TO LIST DATA FOR INPUT SELL ORDER NUMBER
function list4SO(enFunc, txt2Query, inpTxtName, extQuery) {
    if (enFunc === 1) {
        // console.log('enFunc : ' + enFunc + " type of= "+typeof enFunc);
        // console.log('text2query : ' + txt2Query);
        // console.log('input text name : ' + inpTxtName);
        // console.log('ext query : ' + extQuery);
        return;
    }

    if (enFunc === 2) {
        // console.log('enFunc : ' + enFunc);
        // console.log('text2query : ' + txt2Query);
        // console.log('input text name : ' + inpTxtName);
        // console.log('ext query : ' + extQuery);

        if (txt2Query != "") {
            queryData(
                "php4SO.php?command=query4SO&field2Query=" +
                inpTxtName +
                "&fieldReturn=" +
                extQuery +
                "&field2Show=wg_vlpn" +
                "&fieldValue=" +
                escape(txt2Query)
            );
            {
                document.getElementById("id4_SOSuppLogis").value = xhr_object.responseText;
                // document.getElementById("id4_SOCustomer").value = '000001';
                // $("#id4_SOCustomer option[value='000001']").prop("selected", true);
            }
            queryData(
                "php4SO.php?command=query4SO&field2Query=" +
                inpTxtName +
                "&fieldReturn=" +
                extQuery +
                "&field2Show=wg_code4customer" +
                "&fieldValue=" +
                escape(txt2Query)
            );
            {
                document.getElementById("id4_SOCustomer").value = xhr_object.responseText;
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