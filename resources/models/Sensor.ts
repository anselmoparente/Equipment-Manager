export class Sensor {
    id: number;
    equipamento_id: number;
    valor_atual: number | null;

    constructor(id: number, equipamento_id: number, valor_atual: number | null = null) {
        this.id = id;
        this.equipamento_id = equipamento_id;
        this.valor_atual = valor_atual;
    }

    // Método para atualizar o valor do sensor
    atualizarValor(valor: number): void {
        this.valor_atual = valor;
    }
}
