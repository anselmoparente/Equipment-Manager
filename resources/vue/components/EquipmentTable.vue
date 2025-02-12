<script setup lang="ts">
import { Equipamento } from '../../models/Equipamento';

defineProps({
    equipments: { type: Array<Equipamento>, required: true },
});
</script>

<template>
    <div class="equipments-table">
        <table>
            <thead>
                <tr>
                    <th>
                        <p>Nome</p>
                    </th>
                    <th>
                        <p>Parâmetro</p>
                    </th>
                    <th>
                        <p>Limite mínimo</p>
                    </th>
                    <th>
                        <p>Limite máximo</p>
                    </th>
                    <th>
                        <p>Status</p>
                    </th>
                    <th>
                        <p>Valor</p>
                    </th>
                    <th>
                        <p>Alertas</p>
                    </th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="equipment in equipments" :key="equipment.id">
                    <td>
                        <p>{{ equipment.nome }}</p>
                    </td>
                    <td>
                        <p>{{ equipment.parametro }}</p>
                    </td>
                    <td>
                        <p>{{ equipment.limite_min }}</p>
                    </td>
                    <td>
                        <p>{{ equipment.limite_max }}</p>
                    </td>
                    <td>
                        <p>on</p>
                    </td>
                    <td>
                        <p>{{ equipment.sensor.valor_atual != null ? equipment.sensor.valor_atual : '-'}}</p>
                    </td>
                    <td> <i class="material-symbols-outlined">info</i> </td>
                </tr>
            </tbody>
        </table>
    </div>
</template>

<style scoped>
p {
    color: #141414;
    font-family: Montserrat;
    font-size: 16px;
    font-weight: 500;
    padding: 0;
    margin: 0;
}

.equipments-table {
    margin-top: 16px;
    max-height: 65%;
    overflow-y: auto;
    width: calc(100vw - 128px);
}

.students-table i {
    color: #898F8B;
}

.equipments-table table {
    border-collapse: collapse;
    width: 100%;
}

.equipments-table td {
    border-bottom: 1px solid #ddd;
    padding: 12px;
    text-align: center;
}

.equipments-table th {
    background-color: #F0F5F2;
    border-bottom: 1px solid #ddd;
    padding: 12px;
    position: sticky;
    text-align: center;
    top: 0;
    z-index: 1;
}

.equipments-table tr:hover {
    background-color: #F0F5F2;
    cursor: pointer;
}

.equipments-table tr:hover td:first-child {
    text-decoration: underline;
}

.equipments-table th:first-child {
    border-top-left-radius: 12px;
}

.equipments-table th:last-child {
    border-top-right-radius: 12px;
}

.equipments-table td:first-child {
    text-align: left;
}

.equipments-table th:first-child,
.equipments-table td:first-child {
    width: 27.5%;
}

.equipments-table th:nth-child(2),
.equipments-table td:nth-child(2) {
    width: 10%;
}

.equipments-table th:nth-child(3),
.equipments-table td:nth-child(3) {
    width: 25%;
}

.equipments-table th:nth-child(4),
.equipments-table td:nth-child(4) {
    width: 15%;
}

.equipments-table th:nth-child(5),
.equipments-table td:nth-child(5) {
    width: 17.5%;
}

.equipments-table th:last-child,
.equipments-table td:last-child {
    width: 5%;
}
</style>