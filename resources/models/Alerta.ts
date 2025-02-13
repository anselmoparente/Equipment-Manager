export class Alerta {
    id: number;
    equipamento_id: number;
    valor: number;
    mensagem: string;
    created_at: Date;

    constructor(id: number, equipamento_id: number, valor: number, mensagem: string, created_at: Date) {
        this.id = id;
        this.equipamento_id = equipamento_id;
        this.valor = valor;
        this.mensagem = mensagem;
        this.created_at = created_at;
    }
}
