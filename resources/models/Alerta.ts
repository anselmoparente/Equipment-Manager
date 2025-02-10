export class Alerta {
    id: number;
    equipamento_id: number;
    valor: number;
    mensagem: string;

    constructor(id: number, equipamento_id: number, valor: number, mensagem: string) {
        this.id = id;
        this.equipamento_id = equipamento_id;
        this.valor = valor;
        this.mensagem = mensagem;
    }
}
