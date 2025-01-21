<?php

declare(strict_types=1);

namespace App\Application\Actions\Paciente;

use App\Domain\Mensagem;
use App\Domain\Paciente\Paciente;
use Slim\Psr7\Response;

class CadPacienteAction extends PacienteAction
{
    protected function action() : Response 
    {
        $data = $this->request->getParsedBody();
        $id = '' == $data['id'] ? null : (int) $data['id'];
        $ativo = 'true' == $data['ativo'] ? true : false;

        try {
            $paciente = Paciente::create($id, $data['nome'], $data['data_nascimento'], $data['sexo'], $data['nome_mae'], $data['email'], $data['cpf'], $data['cep'], $data['nome_rua'], $data['numero_casa'], $data['bairro'], $data['uf'], $ativo);

        } catch (\Throwable $th) {
            return $this->respondWithData(Mensagem::response('error', $th->getMessage(), 400));
        }


        $return = !$id ? $this->pacienteRepository->cadastrate($paciente) : $this->pacienteRepository->update($paciente);

        // $return = !$id ? '$this->pacienteRepository->cadastrate($paciente)' : '$this->pacienteRepository->update($paciente)';

        return $this->respondWithData($return[0], $return[1]);

    }


}
