<script setup lang="ts">
import axios from 'axios';
import { onMounted, ref } from 'vue';

import { Alerta } from '../../models/Alerta';
import { Equipamento } from '../../models/Equipamento';

const emit = defineEmits(['close']);

const props = defineProps({
    isOpen: { type: Boolean, required: true },
    equipment: { type: Equipamento },
});

const alerts = ref<Alerta[]>([]);

const close = () => {
    emit('close');
};

async function fetchAlerts() {
    try {
        const response = await axios.get('/alertas');
        alerts.value = response.data;
        console.log(alerts.value);
    } catch (error) {
        console.error('Erro ao buscar alertas:', error);
    }
};

onMounted(() => {
    fetchAlerts();
});
</script>

<template>
    <div v-if="isOpen" class="dialog-overlay" @click="close">
        <div class="dialog-container" @click.stop>
            <h1>Alertas</h1>
            <div class="equipments-table">
                <table>
                    <thead>
                        <tr>
                            <th>
                                <p>Equipamento</p>
                            </th>
                            <th>
                                <p>Alerta</p>
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="alert in alerts" :key="alert.id">
                            <td>
                                <p>{{ equipment != null ? equipment.nome : '' }}</p>
                            </td>
                            <td>
                                <p>{{ alert.mensagem }}</p>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</template>

<style scoped>
h1,
p {
    color: #141414;
    font-family: Montserrat;
    font-size: 16px;
    font-weight: 500;
    padding: 0;
    margin: 0;
}

h1 {
    font-size: 32px;
    font-weight: 600;
    text-align: center;
}

.dialog-container {
    background: white;
    border-radius: 8px;
    width: 60%;
    overflow: hidden;
    padding: 32px;
    animation: fadeIn 0.3s ease-in-out;
}

.dialog-overlay {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(0, 0, 0, 0.5);
    display: flex;
    justify-content: center;
    align-items: center;
    z-index: 1000;
}

.equipments-table {
    margin-top: 16px;
    max-height: 65%;
    overflow-y: auto;
    width: 100%;
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

.equipments-table th:first-child {
    border-top-left-radius: 12px;
}

.equipments-table th:last-child {
    border-top-right-radius: 12px;
}

.equipments-table th:first-child,
.equipments-table td:first-child {
    width: 20%;
}

.equipments-table th:last-child,
.equipments-table td:last-child {
    width: 80%;
}
</style>