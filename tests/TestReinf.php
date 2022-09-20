<php

namespace App\Services\Transmitir\assets;

use App\Models\BaseModel;
use App\Models\evento\R1000;

class R1000tx2 extends Tx2
{
    protected $tipo;

    function obterTx2(R1000 $r1000)
    {
        $this->tipo = $r1000->tipo;
            $this->g($this->getTipoTransferencia());
        if ($this->tipo !== BaseModel::STATUS_EXCLUSAO) {
            $this->in('tpAmb_4', BaseModel::AMBIENTE_ENVIO_RECEITA);
            $this->in('procEmi_5', $r1000->procEmi);
            $this->in('verProc_6', $r1000->verProc);
            $this->in('tpInsc_8', $r1000->tpInsc);
            $this->in('nrInsc_9', (int)$r1000->tpInsc === 1 ? substr($r1000->nrInsc, 0, 8) : $r1000->nrInsc);
            $this->in('iniValid_13', '2022-08'); //$r1000->iniValid);
//            $this->in('iniValid_13', $r1000->iniValid);
            $this->in('fimValid_14', $r1000->fimValid);
            $this->in('classTrib_16', $r1000->classTrib);
            $this->in('indEscrituracao_17', $r1000->indEscrituracao);
            $this->in('indDesoneracao_18', $r1000->indDesoneracao);
            $this->in('indAcordoIsenMulta_19', $r1000->indAcordoIsenMulta);
            $this->in('indSitPJ_20', $r1000->indSitPJ);
            $this->in('nmCtt_22', $r1000->nmCtt);
            $this->in('cpfCtt_23', $r1000->cpfCtt);
            $this->in('foneFixo_24', $r1000->foneFixo);
            $this->in('foneCel_25', $r1000->foneCel);
            $this->in('email_26', $r1000->email);
//            $this->in('ideEFR_34', 'N');//$r1000->ideEFR);
//            $this->in('cnpjEFR_35', '15412257000128'); //$r1000->cnpjEFR);
            $this->in('ideEFR_34', $r1000->ideEFR);
            $this->in('cnpjEFR_35',$r1000->cnpjEFR);
            $this->g('INCLUIRSOFTHOUSE_27');
            $this->in('cnpjSoftHouse_28', '07695627000153');
            $this->in('nmRazao_29', 'Infortech');
            $this->in('nmCont_30', 'Tulio Goncalves');
            $this->in('telefone_31', '67999947173');
            $this->in('email_32', 'tuliogoncalves@gmail.com');
            $this->g('SALVARSOFTHOUSE_27');
            $this->g('SALVARR1000');
        }else if ($this->tipo === BaseModel::STATUS_EXCLUSAO){
            $this->in('tpAmb_4', BaseModel::AMBIENTE_ENVIO_RECEITA);
            $this->in('procEmi_5', $r1000->procEmi);
            $this->in('verProc_6', $r1000->verProc);
            $this->in('tpInsc_8', $r1000->tpInsc);
            $this->in('nrInsc_9', (int)$r1000->tpInsc === 1 ? substr($r1000->nrInsc, 0, 8) : $r1000->nrInsc);
            $this->in('iniValid_13', $r1000->iniValid);
            $this->in('fimValid_14', $r1000->fimValid);
            $this->g('SALVARR1000');
        }


        return $this->txt;
    }

    public function getTipoTransferencia()
    {
        switch ($this->tipo) {
            case BaseModel::STATUS_INCLUSAO:
                return BaseModel::STATUS_INCLUSAO_R1000TX2;
            case BaseModel::STATUS_ALTERACAO:
                return BaseModel::STATUS_ALTERACAO_R1000TX2;
            case  BaseModel::STATUS_EXCLUSAO:
                return BaseModel::STATUS_EXCLUSAO_R1000TX2;
        };
    }

}