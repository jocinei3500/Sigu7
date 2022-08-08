function calcHoraOpUsina() {
    var hinicial, hfinal, h1, h2, m1, m2, total;

    hinicial = document.diaria.edInicioOpUsina.value;
    if (hinicial == '') {
        document.diaria.edTotalOpUsina.value = 0;
        exit;
    }
    hinicial = hinicial.split(':');
    hfinal = document.diaria.edFimOpUsina.value;
    if (hfinal == '') {
        document.diaria.edTotalOpUsina.value = 0;
        exit;
    }
    hfinal = hfinal.split(':');

    h1 = hinicial[0];
    m1 = hinicial[1];

    h2 = hfinal[0];
    m2 = hfinal[1];

    hinicial = parseFloat(h1) * 60 + parseFloat(m1);
    hfinal = parseFloat(h2) * 60 + parseFloat(m2);

    total = hfinal - hinicial;

    h2 = total / 60;
    if (h2 < 10) {
        h2 = h2.toString();
        h2 = h2.substr(0, 1);
        h1 = 0 + h2;
    } else {
        h2 = h2.toString();
        h2 = h2.substr(0, 2);
        h1 = h2;
    }
    m1 = (total - (parseFloat(h2) * 60));
    if (m1 < 10) {
        m1 = m1.toString();
        m1 = 0 + m1;
    }
    total = h1 + ':' + m1;
    document.diaria.edTotalOpUsina.value = total;

}

function calcHoraOpCaldeira() {
    var hinicial, hfinal, h1, h2, m1, m2, total;

    hinicial = document.diaria.edHIniOpC.value;
    if (hinicial == '') {
        exit;
    }
    hinicial = hinicial.split(':');
    hfinal = document.diaria.edHFimOpC.value;
    if (hfinal == '') {
        exit;
    }
    hfinal = hfinal.split(':');

    h1 = hinicial[0];
    m1 = hinicial[1];

    h2 = hfinal[0];
    m2 = hfinal[1];

    hinicial = parseFloat(h1) * 60 + parseFloat(m1);
    hfinal = parseFloat(h2) * 60 + parseFloat(m2);

    total = hfinal - hinicial;

    h2 = total / 60;
    if (h2 < 10) {
        h2 = h2.toString();
        h2 = h2.substr(0, 1);
        h1 = 0 + h2;
    } else {
        h2 = h2.toString();
        h2 = h2.substr(0, 2);
        h1 = h2;
    }

    m1 = (total - (parseFloat(h2) * 60));
    if (m1 < 10) {
        m1 = m1.toString();
        m1 = 0 + m1;
    }
    total = h1 + ':' + m1;
    document.diaria.edTOpC.value = total;

}
//-------------------------------------------------------------------------------------------

function calcHorimUsina() {
    var hinicial, hfinal, h1, h2, m1, m2, total;

    hinicial = document.diaria.edHorIniUsina.value;
    if (hinicial == '') {
        exit;
    }
    hinicial = hinicial.split(':');
    hfinal = document.diaria.edHorFimUsina.value;
    if (hfinal == '') {
        document.diaria.edTotalHorUsina.value = 0;
        exit;
    }
    hfinal = hfinal.split(':');

    h1 = hinicial[0];
    m1 = hinicial[1];

    h2 = hfinal[0];
    m2 = hfinal[1];

    hinicial = parseFloat(h1) * 60 + parseFloat(m1);
    hfinal = parseFloat(h2) * 60 + parseFloat(m2);

    total = hfinal - hinicial;

    h2 = total / 60;
    if (h2 < 10) {
        h2 = h2.toString();
        h2 = h2.substr(0, 1);
        h1 = 0 + h2;
    } else {
        h2 = h2.toString();
        h2 = h2.substr(0, 2);
        h1 = h2;
    }
    m1 = (total - (parseFloat(h2) * 60));
    if (m1 < 10) {
        m1 = m1.toString();
        m1 = 0 + m1;
    }
    total = h1 + ':' + m1;
    document.diaria.edTotalHorUsina.value = total;

}

function calcHorimetroUsina() {
    var h1, h2, total;
    h1 = document.diaria.edHorIniUsina.value;
    h2 = document.diaria.edHorFimUsina.value;
    h1 = parseFloat(h1);
    h2 = parseFloat(h2);
    total = h2 - h1;
    document.diaria.edTotalHorUsina.value = total;
}

function calcHorimetroCaldeira() {
    var h1, h2, total;
    h1 = document.diaria.edHmIniC.value;
    h2 = document.diaria.edHmFimC.value;
    h1 = parseFloat(h1);
    h2 = parseFloat(h2);
    total = h2 - h1;
    total = total.toFixed(2);
    document.diaria.edTHmC.value = total;
}

//----------------------------------------------------------------------------
//CALCULA HORÃMETRO DO GERADOR....
function calcHorimetroGerador() {
    var h1, h2, total;
    h1 = document.diaria.edHorIniGerador.value;
    h2 = document.diaria.edHorFimGerador.value;
    if (h2 == '') {
        document.diaria.edTotalGerador.value = 0;
        exit;
    }
    h1 = parseFloat(h1);
    h2 = parseFloat(h2);
    total = h2 - h1;
    total = total.toFixed(1);
    document.diaria.edTotalGerador.value = total;

}
//----------------------------------------------------------------------------
//CALCULA CONSUMO DE CAP....
function calcConsumoCap()
{
    var consumo, estoqueAnt, entrada, estoqueFinal, cm;
    estoqueAnt = parseInt(document.diaria.edEstqAntCap.value);
    entrada = parseFloat(document.diaria.edRcbCap.value);
    estoqueFinal = parseFloat(document.diaria.edEstqFCap.value);
    cm = document.diaria.edCmCap.value;
    if (cm == '') {
        estoqueFinal = estoqueAnt + entrada;
        document.diaria.edEstqFCap.value = estoqueFinal;
        document.diaria.edCnsCap.value = 0;
    } else {
        consumo = estoqueAnt + entrada - estoqueFinal;
        document.diaria.edCnsCap.value = consumo;
    }
    teorCap();

}
//----------------------------------------------------------------------------
//CALCULA CONSUMO DE XISTO....

function calcConsumoXisto()
{
    var consumo, estoqueAnt, entrada, estoqueFinal, cm;
    estoqueAnt = parseInt(document.diaria.edEstqAntX.value);
    entrada = parseFloat(document.diaria.edRcbX.value);
    estoqueFinal = parseFloat(document.diaria.edEstqFX.value);
    cm = document.diaria.edCmX.value;
    if (cm == '') {
        estoqueFinal = estoqueAnt + entrada;
        document.diaria.edEstqFX.value = estoqueFinal;
        document.diaria.edCnsX.value = 0;
    } else {
        consumo = estoqueAnt + entrada - estoqueFinal;
        document.diaria.edCnsX.value = consumo;
    }
    teorX();

}
//----------------------------------------------------------------------------
//CALCULA CONSUMO DE DIESEL DA CALDEIRA....
function calcConsumoDieC()
{
    var consumo, estoqueAnt, entrada, estoqueFinal, cm;
    estoqueAnt = parseInt(document.diaria.edEstqAntDC.value);
    entrada = parseFloat(document.diaria.edRcbDC.value);
    estoqueFinal = parseFloat(document.diaria.edEstqFDC.value);
    cm = document.diaria.edCmDC.value;
    if (cm == '') {
        estoqueFinal = estoqueAnt + entrada;
        document.diaria.edEstqFDC.value = estoqueFinal;
        document.diaria.edCnsDC.value = 0;
    } else {
        consumo = estoqueAnt + entrada - estoqueFinal;
        document.diaria.edCnsDC.value = consumo;
    }
}
//----------------------------------------------------------------------------
//CALCULA CONSUMO DE DIESEL NO GERADOR....

function calcConsumoDieG()
{
    var consumo, estoqueAnt, entrada, estoqueFinal;
    estoqueAnt = parseInt(document.diaria.edEstqAntDG.value);
    entrada = parseFloat(document.diaria.edRcbDG.value);
    estoqueFinal = parseFloat(document.diaria.edEstqFDG.value);

    consumo = estoqueAnt + entrada - estoqueFinal;
    document.diaria.edCnsDG.value = consumo;

}
//----------------------------------------------------------------------------
//CALCULA CONSUMO DE CAL
function calcEstoqueFinalCAL()
{
    var consumo, estoqueAnt, ent, estoqueFinal;
    ent = document.diaria.edRcbCal.value;
    if (ent == '') {
        document.diaria.edRcbCal.value = 0
        ent = 0;
    }
    estoqueAnt = parseFloat(document.diaria.edEstqAntCal.value);
    consumo = document.diaria.edCnsCAL.value;
    if (consumo == '') {
        document.diaria.edCnsCAL.value = 0;
        consumo = 0;
    }
    ent = parseFloat(ent);
    consumo = parseFloat(consumo);
    estoqueFinal = estoqueAnt + ent - consumo;
    document.diaria.edEstqFCal.value = estoqueFinal;
}
//------------------------------------------------------------------------------
//CALCULA TOTAL DE SAIDA DE MATERIAL BETUMINOSO
function calcMassa()
{
    var qtdM = new Array(), total;

    if (document.diaria.edQtdMat1.value == '') {
        qtdM[0] = 0;
    } else {
        qtdM[0] = parseInt(document.diaria.edQtdMat1.value);
    }

    if (document.diaria.edQtdMat2.value == '') {
        qtdM[1] = 0;
    } else {
        qtdM[1] = parseInt(document.diaria.edQtdMat2.value);
    }

    if (document.diaria.edQtdMat3.value == '') {
        qtdM[2] = 0;
    } else {
        qtdM[2] = parseInt(document.diaria.edQtdMat3.value);
    }

    if (document.diaria.edQtdMat4.value == '') {
        qtdM[3] = 0;
    } else {
        qtdM[3] = parseInt(document.diaria.edQtdMat4.value);
    }

    if (document.diaria.edQtdMat5.value == '') {
        qtdM[4] = 0;
    } else {
        qtdM[4] = parseInt(document.diaria.edQtdMat5.value);
    }

    if (document.diaria.edQtdMat6.value == '') {
        qtdM[5] = 0;
    } else {
        qtdM[5] = parseInt(document.diaria.edQtdMat6.value);
    }

    if (document.diaria.edQtdMat7.value == '') {
        qtdM[6] = 0;
    } else {
        qtdM[6] = parseInt(document.diaria.edQtdMat7.value);
    }

    if (document.diaria.edQtdMat8.value == '') {
        qtdM[7] = 0;
    } else {
        qtdM[7] = parseInt(document.diaria.edQtdMat8.value);
    }
    total = qtdM[0] + qtdM[1] + qtdM[2] + qtdM[3] + qtdM[4] + qtdM[5] + qtdM[6] + qtdM[7];
    document.diaria.edTotalMassa.value = total;
    document.diaria.edProdDiaria.value = total;
    teorCap();
    teorX();
}
//------------------------------------------------------------------------------
//CALCULA TOTAL DE SAIDA DE MATERIAL BETUMINOSO
function calcCargas()
{
    var qtdM = new Array(), total;

    if (document.diaria.edCargas1.value == '') {
        qtdM[0] = 0;
    } else {
        qtdM[0] = parseInt(document.diaria.edCargas1.value);
    }

    if (document.diaria.edCargas2.value == '') {
        qtdM[1] = 0;
    } else {
        qtdM[1] = parseInt(document.diaria.edCargas2.value);
    }

    if (document.diaria.edCargas3.value == '') {
        qtdM[2] = 0;
    } else {
        qtdM[2] = parseInt(document.diaria.edCargas3.value);
    }

    if (document.diaria.edCargas4.value == '') {
        qtdM[3] = 0;
    } else {
        qtdM[3] = parseInt(document.diaria.edCargas4.value);
    }

    if (document.diaria.edCargas5.value == '') {
        qtdM[4] = 0;
    } else {
        qtdM[4] = parseInt(document.diaria.edCargas5.value);
    }

    if (document.diaria.edCargas6.value == '') {
        qtdM[5] = 0;
    } else {
        qtdM[5] = parseInt(document.diaria.edCargas6.value);
    }

    if (document.diaria.edCargas7.value == '') {
        qtdM[6] = 0;
    } else {
        qtdM[6] = parseInt(document.diaria.edCargas7.value);
    }

    if (document.diaria.edCargas8.value == '') {
        qtdM[7] = 0;
    } else {
        qtdM[7] = parseInt(document.diaria.edCargas8.value);
    }
    total = qtdM[0] + qtdM[1] + qtdM[2] + qtdM[3] + qtdM[4] + qtdM[5] + qtdM[6] + qtdM[7];
    document.diaria.edTotalCargas.value = total;
}
//---------------------------------------------------------------------------------------------------
//CALCULA TEOR CAP
function teorCap() {
    var consumo, producao, teor;
    consumo = document.diaria.edCnsCap.value;
    if (consumo == '') {
        exit;
    }
    producao = document.diaria.edTotalMassa.value;
    if (producao == '') {
        exit;
    }

    teor = (consumo / producao) * 100;
    teor = teor.toFixed(2);
    document.diaria.edTeorCap.value = teor;

}
//CALCULA TEOR CAP
function teorX() {
    var consumo, producao, teor;
    consumo = document.diaria.edCnsX.value;
    if (consumo == '') {
        exit;
    }
    producao = document.diaria.edTotalMassa.value;
    if (producao == '') {
        exit;
    }

    teor = (consumo / producao) * 1000;
    teor = teor.toFixed(2);
    document.diaria.edTeorX.value = teor;

}

//CALCULA TEOR CAL
function teorCAL() {
    var consumo, producao, teor;
    consumo = document.diaria.edCnsCAL.value;
    if (consumo == '') {
        exit;
    }
    producao = document.diaria.edTotalMassa.value;
    if (producao == '') {
        exit;
    }

    teor = (parseFloat(consumo) / parseFloat(producao)) * 100;
    teor = teor.toFixed(2);
    document.diaria.edTeorCal.value = teor;

}
//------------------------------------------------------------------------------
//CALCULA TEOR DIESEL CALDEIRA
function ConsumoHoraDC() {
    var consumo, tHoras, teor;
    consumo = document.diaria.edCnsDC.value;
    if (consumo == '0') {
        exit;
        document.diaria.edTeorDC.value = 0;
    }
    tHoras = document.diaria.edTHmC.value;
    if (tHoras == '0') {
        exit;
        document.diaria.edTeorDC.value = 0;
    }
    consumo = parseFloat(consumo);
    tHoras = parseFloat(tHoras);

    teor = consumo / tHoras;
    teor = teor.toFixed(2);
    document.diaria.edTeorDC.value = teor;
}

//------------------------------------------------------------------------------
//CALCULA TEOR DIESEL DO GERADOR
function ConsumoHoraDG() {
    var consumo, tHoras, teor;
    consumo = document.diaria.edCnsDG.value;
    if (consumo == '0') {
        document.diaria.edTeorDG.value = 0;
        exit;
    }
    tHoras = document.diaria.edTotalGerador.value;
    if (tHoras == '0') {
        document.diaria.edTeorDG.value = 0;
        exit;
    }
    consumo = parseFloat(consumo);
    tHoras = parseFloat(tHoras);

    teor = consumo / tHoras;
    teor = teor.toFixed(2);
    document.diaria.edTeorDG.value = teor;

}

//-------------------------------------------
//CALCULA CONSUMO DE DIESEL
function calcCnsD()
{
    var cald, ger, consumo, EstqF, EstqIni, entrada;
    EstqIni = parseFloat(document.diaria.edEstqAntD.value);
    entrada = parseFloat(document.diaria.edRcbD.value);
    cald = parseFloat(document.diaria.edCnsDC.value);
    ger = parseFloat(document.diaria.edCnsDG.value);
    consumo = cald + ger;
    EstqF = EstqIni + entrada - consumo;
    document.diaria.edCnsD.value = consumo;
    document.diaria.edEstqFD.value = EstqF;


}
//-----------------------Máscara Data


function calcDelta() {
    var ti, tf, delta;
    ti = document.diaria.edTIniCAP.value;
    tf = document.diaria.edTFimCAP.value;
    if ((ti != '') && (tf != '')) {
        delta = parseFloat(tf) - parseFloat(ti);
        document.diaria.edDelta.value = delta;
    }

}

function printDiv(id, pg) {
    var oPrint, oJan;
    oPrint = window.document.getElementById(id).innerHTML;
    oJan = window.open(pg);
    oJan.document.write(oPrint);
    oJan.window.print();
    oJan.document.close();
    oJan.focus();
}
