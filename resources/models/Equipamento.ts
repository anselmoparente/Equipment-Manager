import { Sensor } from "./Sensor";

export class Equipamento {
    id: number;
    nome: string;
    status: boolean;
    parametro: string;
    limite_min: number;
    limite_max: number;
    topic: string;
    sensor: Sensor;

    constructor(id: number, nome: string, status: boolean, parametro: string, limite_min: number, limite_max: number, topic: string, sensor: Sensor) {
        this.id = id;
        this.nome = nome;
        this.status = status;
        this.parametro = parametro;
        this.limite_min = limite_min;
        this.limite_max = limite_max;
        this.topic = topic;
        this.sensor = sensor;
    }

    // Método para atualizar o valor do sensor
    atualizarSensor(valor: number): void {
        this.sensor.valor_atual = valor;
    }

    // Método para atualizar o status
    atualizarStatus(status: boolean): void {
        this.status = status;
    }
}
