<script setup lang="ts">
import { computed } from 'vue';
import { Equipamento } from '../../models/Equipamento';

const emit = defineEmits(['toggleStatus']);

const props = defineProps({
    equipments: { type: Array<Equipamento>, required: true },
});

const toggleStatus = (equipment: Equipamento) => {
    emit('toggleStatus', equipment);
};

const sortedEquipments = computed(() => {
    return [...props.equipments].sort((a, b) => Number(b.status) - Number(a.status));
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
                <tr v-for="equipment in sortedEquipments" :key="equipment.id">
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
                        <label class="switch">
                            <input type="checkbox" :checked="equipment.status" @change="toggleStatus(equipment)" />
                            <span class="slider"></span>
                        </label>
                    </td>
                    <td>
                        <p>{{ equipment.sensor.valor_atual != null ? equipment.sensor.valor_atual : '-' }}</p>
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
    width: 25%;
}

.equipments-table th:nth-child(2),
.equipments-table td:nth-child(2) {
    width: 25%;
}

.equipments-table th:nth-child(3),
.equipments-table td:nth-child(3) {
    width: 10%;
}

.equipments-table th:nth-child(4),
.equipments-table td:nth-child(4) {
    width: 10%;
}

.equipments-table th:nth-child(5),
.equipments-table td:nth-child(5) {
    width: 10%;
}

.equipments-table th:last-child,
.equipments-table td:last-child {
    width: 10%;
}

.equipments-table th:last-child,
.equipments-table td:last-child {
    width: 10%;
}

input:checked+.slider {
    background-color: #4CAF50;
}

input:checked+.slider:before {
    transform: translateX(20px);
}

.slider {
    position: absolute;
    cursor: pointer;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background-color: #ccc;
    transition: .4s;
    border-radius: 20px;
}

.slider:before {
    position: absolute;
    content: "";
    height: 14px;
    width: 14px;
    left: 3px;
    bottom: 3px;
    background-color: white;
    transition: .4s;
    border-radius: 50%;
}

.switch {
    position: relative;
    display: inline-block;
    width: 40px;
    height: 20px;
}

.switch input {
    opacity: 0;
    width: 0;
    height: 0;
}
</style>