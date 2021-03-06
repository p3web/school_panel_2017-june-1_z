var flag = false; //---- first Print set True
function HandelIframeContent(IFRAMEID , ContentID , DividerId) {
    if(!flag) {
        var IFRAME = document.getElementById(IFRAMEID);
        var iDoc = IFRAME.contentDocument || IFRAME.contentWindow.document;
        var contentid = iDoc.getElementById(ContentID);
        IFRAME.style.display = 'none';
        document.getElementById(DividerId).appendChild(contentid);
        flag = true;
    }
    CreateJPEG(document.body);
}

function CreateIFRAME(src) {
    var iframe ;
    iframe = document.getElementById('PrintIFrame');
    if(iframe == null) {
        iframe = document.createElement('iframe');
        iframe.style.cssText = 'position : fixed;top:0;left:20000vw; width:1648px;height:1191px;';
        iframe.setAttribute('id', 'PrintIFrame');
        iframe.setAttribute('src' , src);
        document.body.appendChild(iframe);
    }
}


function printPage(){
    var Export = document.getElementById('PrintIFrame');
    Export.contentWindow.focus();
    Export.contentWindow.print();
}

function CreateJPEG(elem) {
    domtoimage.toJpeg(elem, { quality: 1 })
        .then(function (dataUrl) {
            CreateImageForPrint(dataUrl , PrintIframe);
        });
}

function CreateImageForPrint(dataUrl , callBack){
    var img = document.createElement('img');
    img.src = dataUrl;
    var iframe ;
    var Body;
    iframe = document.getElementById('PrintIFrame');
    if(iframe == null) {
        iframe = document.createElement('iframe');
        iframe.style.cssText = 'position : fixed;top:0;left:2000vw;';
        iframe.setAttribute('id', 'PrintIFrame');
        document.body.appendChild(iframe);
    }
    iframe = document.getElementById('PrintIFrame');
    Body = iframe.contentDocument.body;
    Body.innerHTML = '';
    Body.appendChild(img);
    setTimeout(function () {
        callBack();
    },200);
}

function PrintIframe(){
    var frm = document.getElementById('PrintIFrame').contentWindow;
    frm.focus();// focus on contentWindow is needed on some ie versions
    frm.print();
}

function SvgSendOut(){ ///----> get Svg from Iframe and append to iframe container ........ For image export
    var IFRAME = document.getElementById('DonutChart').children[0];
    var iDoc = IFRAME.contentDocument || IFRAME.contentWindow.document;
    var contentid = iDoc.getElementById('DonutChart');
    IFRAME.style.display = 'none';
    document.getElementById('DonutChart').appendChild(contentid);
}