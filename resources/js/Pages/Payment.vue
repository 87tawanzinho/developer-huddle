<template>
    <div
        class="checkout-page min-h-screen bg-gray-50 flex items-center justify-center p-6"
    >
        <div class="max-w-lg w-full bg-white shadow-md rounded-lg p-8">
            <h1 class="text-2xl font-bold text-center mb-6">
                Assinatura - Checkout
            </h1>
            <el-form
                :model="form"
                :rules="rules"
                ref="formRef"
                label-width="100px"
            >
                <!-- Nome Completo -->
                <el-form-item label="Nome" prop="name">
                    <el-input
                        v-model="form.name"
                        placeholder="Digite seu nome completo"
                    ></el-input>
                </el-form-item>

                <!-- Email -->
                <el-form-item label="Email" prop="email">
                    <el-input
                        v-model="form.email"
                        placeholder="Digite seu email"
                    ></el-input>
                </el-form-item>

                <!-- Telefone -->
                <el-form-item label="Telefone" prop="phone">
                    <el-input
                        v-model="form.phone"
                        placeholder="Digite seu telefone"
                    ></el-input>
                </el-form-item>

                <!-- Valor da Assinatura -->
                <el-form-item label="Valor (R$)" prop="value">
                    <el-input-number
                        v-model="form.value"
                        :min="1"
                        placeholder="Insira o valor"
                    ></el-input-number>
                </el-form-item>

                <!-- Data de Início -->
                <el-form-item label="Início" prop="startDate">
                    <el-date-picker
                        v-model="form.startDate"
                        type="date"
                        placeholder="Selecione a data"
                        :format="'YYYY-MM-DD'"
                    ></el-date-picker>
                </el-form-item>

                <!-- Botão de Enviar -->
                <el-form-item>
                    <el-button type="primary" @click="submitForm"
                        >Finalizar</el-button
                    >
                </el-form-item>
            </el-form>
        </div>
    </div>
</template>

<script>
import { ref } from "vue";
import axios from "axios";

export default {
    name: "CheckoutPage",
    setup() {
        const form = ref({
            name: "",
            email: "",
            phone: "",
            value: 0,
            startDate: "",
        });

        const rules = {
            name: [
                {
                    required: true,
                    message: "O nome é obrigatório",
                    trigger: "blur",
                },
            ],
            email: [
                {
                    required: true,
                    message: "O email é obrigatório",
                    trigger: "blur",
                },
                {
                    type: "email",
                    message: "Insira um email válido",
                    trigger: "blur",
                },
            ],
            phone: [
                {
                    required: true,
                    message: "O telefone é obrigatório",
                    trigger: "blur",
                },
            ],
            value: [
                {
                    required: true,
                    message: "Insira um valor válido",
                    trigger: "blur",
                },
            ],
            startDate: [
                {
                    required: true,
                    message: "A data de início é obrigatória",
                    trigger: "blur",
                },
            ],
        };

        const formRef = ref(null);

        const submitForm = () => {
            formRef.value.validate((valid) => {
                if (valid) {
                    processCheckout();
                } else {
                    console.log("Erro no formulário!");
                    return false;
                }
            });
        };

        const processCheckout = async () => {
            try {
                const { data } = await axios.post(
                    "https://www.asaas.com/api/v3/customers",
                    {
                        name: form.value.name,
                        email: form.value.email,
                        phone: form.value.phone,
                    },
                    {
                        headers: {
                            "Content-Type": "application/json",
                            access_token: "SUA_API_KEY",
                        },
                    },
                );

                const customerId = data.id;

                await axios.post(
                    "https://www.asaas.com/api/v3/subscriptions",
                    {
                        customer: customerId,
                        billingType: "CREDIT_CARD",
                        nextDueDate: form.value.startDate,
                        value: form.value.value,
                        cycle: "MONTHLY",
                        description: "Assinatura Mensal",
                    },
                    {
                        headers: {
                            "Content-Type": "application/json",
                            access_token: "SUA_API_KEY",
                        },
                    },
                );

                alert("Assinatura criada com sucesso!");
            } catch (error) {
                console.error("Erro ao criar assinatura:", error);
                alert("Ocorreu um erro ao processar sua assinatura.");
            }
        };

        return { form, rules, formRef, submitForm };
    },
};
</script>

<style scoped>
.checkout-page {
    background: linear-gradient(to bottom, #f8fafc, #ffffff);
}
</style>
