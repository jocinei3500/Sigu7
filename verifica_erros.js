
function verificaErros()
{

    var i, erro, h1, h2, obs,cadP;
    erro=0;
    if (document.diaria.edInicioOpUsina.value == '') {
        alert('Informe a hora inicial de operação da usina');
        document.diaria.edInicioOpUsina.focus();
        erro = 1;
        exit();

    } else if (document.diaria.edFimOpUsina.value == '') {
        alert('Informe a hora de final de operação da usina');
        document.diaria.edFimOpUsina.focus();
        erro = 1;
        exit();

    } else if (document.diaria.edHorFimUsina.value == '') {
        alert('Informe o horímetro final da usina');
        document.diaria.edHorFimUsina.focus();
        erro = 1;
        exit();

    } else if (document.diaria.edHorFimGerador.value == '') {
        alert('Informe o horímetro final do gerador');
        document.diaria.edHorFimGerador.focus();
        erro = 1;
        exit();

    }
    if (document.diaria.cadP.value=='0') {
        for (i = 0; i < 4; i++) {
            h1 = document.getElementsByName('edHIniP[]')[i].value;
            h2 = document.getElementsByName('edHFP[]')[i].value;
            obs = document.getElementsByName('edObsP[]')[i].value;
            if ((h1 != '') || (h2 != '') || (obs != '')) {
                if (h1 == '') {
                    alert('Hora inicial da parada em branco na linha ' + i+1);
                    erro = 1;
                    document.getElementsByName('edHIniP[]')[i].focus()
                    exit();
                } else if (h2 == '') {
                    alert('Hora inicial da parada em branco na linha ' + i+1);
                    erro = 1;
                    document.getElementsByName('edHFP[]')[i].focus();
                    exit;
                } else if (obs == ''){
                    alert('descrição da parada em branco na linha ' + i+1);
                    erro = 1;
                    document.getElementsByName('edObsP[]')[i].focus();
                    exit();
                }
            } else if (confirm('Não houve paradas durante a produção diária?\n\
        \n\
Deseja prosseguir o cadastro com paradas em branco?')) {
                document.diaria.cadP.value=1;
                i=5;//acima no form se diz que executa se form menor que 4, 
                //sendo 5 não executa mais e pula para o próximo sem ter que executar a função novamente.
            }else{
                exit();
            }
        }
    }


    if (document.diaria.edHIniOpC.value == '') {
        alert('Informe o horário inicial de operação da caldeira');
        document.diaria.edHIniOpC.focus();
        erro = 1;
    }
    else if (document.diaria.edHFimOpC.value == '') {
        alert('Informe o horario final da operação da caldeira');
        document.diaria.edHFimOpC.focus();
        erro = 1;

    } else if (document.diaria.edHmFimC.value == '') {
        alert('Informe o horímetro final da caldeira');
        document.diaria.edHmFimC.focus();
        erro = 1;

    }
    else if (document.diaria.edTIniCAP.value == '') {
        alert('Informe a temperatura inicial do cap');
        document.diaria.edTIniCAP.focus();
        erro = 1;

    }
    else if (document.diaria.edTFimCAP.value == '') {
        alert('Informe a temperatura final do cap');
        document.diaria.edTFimCAP.focus();
        erro = 1;

    }
    //Controle de materiais
    //+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++


    //                        ( conntrole de CAP )
    //                        ===================
    else if (document.diaria.edCnsCap.value <= '0') {
        alert('Informe a medida em "cm" de vazio do tanque de cap');
        document.diaria.edCmCap.focus();
        erro = 1;

    } else if ((document.diaria.edRcbCap.value != '0') || (document.diaria.edNFCap.value != '') || (document.diaria.edFornCap.value != '')) {
        if (document.diaria.edRcbCap.value == '0') {
            alert('Para cadastrar entrada de CAP:\n\
 informe a quantidade de CAP recebido\n\
 ou deixe os dados de entrada de CAP em branco');
            document.diaria.edRcbCap.focus();
            erro = 1;

        } else if (document.diaria.edNFCap.value == '') {
            alert('Para cadastrar entrada de CAP:\n\
Informe o nº da nota fiscal\n\
 ou deixe os dados de entrada de CAP em branco');
            document.diaria.edNFCap.focus();
            erro = 1;

        } else if (document.diaria.edFornCap.value == '') {
            alert('Para cadastrar entrada de CAP informe o fornecedor ou deixe em branco');
            document.diaria.edFornCap.focus();
            erro = 1;

        }
//                      ( controle de Xisto)   
//                      ====================
    } else if (document.diaria.edCnsX.value <= '0') {
        alert('Informe a medida em "cm" de vazio do tanque de XISTO!');
        document.diaria.edCmX.focus();
        erro = 1;

    } else if ((document.diaria.edRcbX.value != '0') || (document.diaria.edNFX.value != '') || (document.diaria.edFornX.value != '')) {
        if (document.diaria.edRcbX.value == '0') {
            alert('Para cadastrar entrada de XISTO: \nInforme a quantidade de XISTO recebido\n\
 \nou deixe os dados de entrada de xisto em branco!');
            document.diaria.edRcbX.focus();
            erro = 1;

        } else if (document.diaria.edNFX.value == '') {
            alert('Para cadastrar entrada de XISTO: \nInforme o nº da nota fiscal de XISTO recebido\n\
 \nou deixe os dados de entrada de xisto em branco!');
            document.diaria.edNFX.focus();
            erro = 1;

        } else if (document.diaria.edFornX.value == '') {
            alert('Para cadastrar entrada de XISTO: \nInforme o fornecedor de XISTO recebido\n\
 \nou deixe os dados de entrada de xisto em branco!');
            document.diaria.edFornX.focus();
            erro = 1;

        }
    }
    else if (document.diaria.edCnsDC.value <= '0') {
        alert('Informe a medida de vazio do tanque de Diesel da CALDEIRA.!');
        document.diaria.edCmDC.focus();
        erro = 1;

    } else if (document.diaria.edCnsDG.value == '0') {
        alert('Informe o estoque final de Diesel do GERADOR!');
        document.diaria.edEstqFDG.focus();
        erro = 1;

    }

    //                      ( controle de CAL) //confirmação de cadastro de cal  
    else if (document.diaria.vcal.value == '0') {
        if (document.diaria.edCnsCAL.value == '0') {
            if (confirm('Foi usado cal na massa? 0\n\
\n\
Deseja deixar consumo de CAL em branco?')) {
                document.diaria.vcal.value = 1;
            }else{
                exit();
            }
        }
    } else if ((document.diaria.edRcbCal.value != '0') || (document.diaria.edNFCal.value != '') || (document.diaria.edFornCal.value != '')) {
        if (document.diaria.edRcbCal.value == '0') {
            alert('Para cadastrar entrada de CAL: \nInforme a quantidade de CAL recebido\n\
 \n ou deixe os dados de entrada de CAL em branco!');
            document.diaria.edNFCal.focus();
            erro = 1;

        } else if (document.diaria.edNFCal.value == '') {
            alert('Para cadastrar entrada de CAL: \nInforme o nº da nota fiscal de CAL recebido\n\
 \nou deixe os dados de entrada de CAL em branco!');
            document.diaria.edNFCal.focus();
            erro = 1;

        } else if (document.diaria.edFornCal.value == '') {
            alert('Para cadastrar entrada de CAL: \nInforme o fornecedor de CAL recebido\n\
 \nou deixe os dados de entrada de CAL em branco!');
            document.diaria.edFornCal.focus();
            erro = 1;
        }

    } else if ((document.diaria.edRcbD.value != '0') || (document.diaria.edNFD.value != '') || (document.diaria.edFornD.value != '')) {
        if (document.diaria.edRcbD.value == '0') {
            alert('Para cadastrar entrada de DIESEL: \nInforme a quantidade de DIESEL recebido\n\
 \n ou deixe os dados de entrada de DIESEL em branco!');
            document.diaria.edNFD.focus();
            erro = 1;


        } else if (document.diaria.edNFD.value == '') {
            alert('Para cadastrar entrada de DIESEL: \nInforme o nº da nota fiscal de DIESEL recebido\n\
 \nou deixe os dados de entrada de DIESEL em branco!');
            document.diaria.edNFD.focus();
            erro = 1;


        } else if (document.diaria.edFornD.value == '') {
            alert('Para cadastrar entrada de DIESEL: \nInforme o fornecedor de DIESEL recebido\n\
 \nou deixe os dados de entrada de DIESEL em branco!');
            document.diaria.edFornD.focus();
            erro = 1;


        }
    } else if (document.diaria.taObs.value == '') {
        alert('O campo Observções gerais está em branco!');
        document.diaria.taObs.focus();
        erro = 1;
        exit();

    }
    //pega dados de saida de materiais
    if (erro == 0) {

        var sdmat = new Array();

        sdmat[1] = document.diaria.edMat1.value;
        sdmat[2] = document.diaria.edMat2.value;
        sdmat[3] = document.diaria.edMat3.value;
        sdmat[4] = document.diaria.edMat4.value;
        sdmat[5] = document.diaria.edMat5.value;
        sdmat[6] = document.diaria.edMat6.value;
        sdmat[7] = document.diaria.edMat7.value;
        sdmat[8] = document.diaria.edMat8.value;

        var sdmatqtd = new Array();

        sdmatqtd[1] = document.diaria.edQtdMat1.value;
        sdmatqtd[2] = document.diaria.edQtdMat2.value;
        sdmatqtd[3] = document.diaria.edQtdMat3.value;
        sdmatqtd[4] = document.diaria.edQtdMat4.value;
        sdmatqtd[5] = document.diaria.edQtdMat5.value;
        sdmatqtd[6] = document.diaria.edQtdMat6.value;
        sdmatqtd[7] = document.diaria.edQtdMat7.value;
        sdmatqtd[8] = document.diaria.edQtdMat8.value;


        var sdqtdcargas = new Array();
        sdqtdcargas[1] = document.diaria.edCargas1.value;
        sdqtdcargas[2] = document.diaria.edCargas2.value;
        sdqtdcargas[3] = document.diaria.edCargas3.value;
        sdqtdcargas[4] = document.diaria.edCargas4.value;
        sdqtdcargas[5] = document.diaria.edCargas5.value;
        sdqtdcargas[6] = document.diaria.edCargas6.value;
        sdqtdcargas[7] = document.diaria.edCargas7.value;
        sdqtdcargas[8] = document.diaria.edCargas8.value;

        var sdMatObra = new Array();

        sdMatObra[1] = document.diaria.edObra1.value;
        sdMatObra[2] = document.diaria.edObra2.value;
        sdMatObra[3] = document.diaria.edObra3.value;
        sdMatObra[4] = document.diaria.edObra4.value;
        sdMatObra[5] = document.diaria.edObra5.value;
        sdMatObra[6] = document.diaria.edObra6.value;
        sdMatObra[7] = document.diaria.edObra7.value;
        sdMatObra[8] = document.diaria.edObra8.value;

        var sdMatTransp = new Array();

        sdMatTransp[1] = document.diaria.edTransportadora1.value;
        sdMatTransp[2] = document.diaria.edTransportadora2.value;
        sdMatTransp[3] = document.diaria.edTransportadora3.value;
        sdMatTransp[4] = document.diaria.edTransportadora4.value;
        sdMatTransp[5] = document.diaria.edTransportadora5.value;
        sdMatTransp[6] = document.diaria.edTransportadora6.value;
        sdMatTransp[7] = document.diaria.edTransportadora7.value;
        sdMatTransp[8] = document.diaria.edTransportadora8.value;
        for (i = 1; i < 9; i++) {
            if (i == 1) {
                if (document.diaria.edMat1.value == '') {
                    alert('Saída de material Betuminoso(Massa)\n\
\n\
Selecione o mateiral betuminoso na linha 1!');
                    document.diaria.edMat1.focus();
                    erro = 1;
                    exit();
                } else if (document.diaria.edQtdMat1.value == '') {
                    alert('Saída de material Betuminoso(Massa)\n\\n\
\n\
\n\
Informe a quantidade de Massa!');
                    document.diaria.edQtdMat1.focus();
                    erro = 1;
                    exit();


                } else if (document.diaria.edCargas1.value == '') {
                    alert('Saída de material Betuminoso(Massa)\n\\n\
\n\
\n\
Informe a quantidade de cargas!');
                    document.diaria.edCargas1.focus();
                    erro = 1;
                    exit();

                } else if (document.diaria.edObra1.value == '') {
                    alert('Saída de material Betuminoso(Massa)\n\\n\
\n\
\n\
Selecione para quanl OBRA a massa foi enviada!');
                    document.diaria.edObra1.focus();
                    erro = 1;
                    exit();

                } else if (document.diaria.edTransportadora1.value == '') {
                    alert('Saída de material Betuminoso(Massa)\n\\n\
\n\
\n\
Selecione a transportadora!');
                    document.diaria.edTransportadora1.focus();
                    erro = 1;
                    exit();
                }

            } else {//else se não é a primeira linha

                if ((sdmat[i] != '') || (sdmatqtd[i] != '') || (sdqtdcargas[i] != '') || (sdMatObra[i] != '') || (sdMatTransp[i] != '')) {
                    if (sdmat[i] == '') {
                        alert('Informe o nome do material betuminoso na linha' + i + '\n\
\n\
ou deixe todos os dados da linha em branco');
                        erro = 1;
                        exit();
                        //---------------//
                    } else if (sdmatqtd[i] == '') {
                        alert('Informe a quantidade de material betuminoso na linha' + i + '\n\
\n\
ou deixe todos os dados da linha m branco!');
                        erro = 1;
                        exit();
                        //---------------//
                    } else if (sdqtdcargas[i] == '') {
                        alert('Informe a quantidade de material betuminoso na linha' + i + '\n\
\n\
ou deixe todos os dados da linha m branco!');
                        erro = 1;
                        exit();
                        //-------------//
                    } else if (sdMatObra[i] == '') {
                        alert('Informe a quantidade de material betuminoso na linha' + i + '\n\
\n\
ou deixe todos os dados da linha m branco!');
                        erro = 1;
                        exit();
                        //-----
                        //----------//
                    } else if (sdMatTransp == '') {
                        alert('Informe a quantidade de material betuminoso na linha' + i + '\n\
\n\
ou deixe todos os dados da linha m branco!');
                        erro = 1;
                        exit();
                        //-------------//
                    }

                }
            }
        }//finaliza o for
    }
    
    
    if(erro==0){
        if(confirm('Cadastrar diária da Usina\n\
\n\
\n\
Confirme o cadastro da Usina!')){
        document.diaria.submit();
        }
    }
}


