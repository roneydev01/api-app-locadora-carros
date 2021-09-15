<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <!--Inicio do card de busca-->
                <div class="card mb-3">
                    <div class="card-header">Busca de Marcas</div>

                    <div class="card-body">
                        <div class="form-row">
                            <div class="col mb-3">
                                <input-container-component
                                    id="inputId"
                                    titulo="ID"
                                    id-help="idHelp"
                                    texto-ajuda="Opcional. Informe o ID do registro."
                                >
                                    <input
                                        type="number"
                                        class="form-control"
                                        id="inputId"
                                        aria-describedby="idHelp"
                                        placeholder="ID"
                                    />
                                </input-container-component>
                            </div>
                            <div class=" col mb-3">
                                <input-container-component
                                    id="inputNome"
                                    titulo="Nome"
                                    id-help="nomeHelp"
                                    texto-ajuda="Opcional. Informe o nome da marca."
                                >
                                    <input
                                        type="text"
                                        class="form-control"
                                        id="inputNome"
                                        aria-describedby="nomeHelp"
                                        placeholder="Nome da marca"
                                    />
                                </input-container-component>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <button
                            type="submit"
                            class="btn btn-primary btn-sm float-right"
                        >
                            Pesquisar
                        </button>
                    </div>
                </div>
                <!--Fim do card de busca-->

                <!--Inicio do card de listagem de marcas-->
                <div class="card">
                    <div class="card-header">Relação de Marcas</div>

                    <div class="card-body"></div>
                    <table-component></table-component>
                    <div class="card-footer">
                        <button
                            type="submit"
                            class="btn btn-primary btn-sm float-right"
                        >
                            Adicionar
                        </button>
                    </div>
                </div>
                <!--Fim do card de listagem de marcas-->
            </div>
        </div>
    </div>
</template>
<script>
import InputContainer from "./InputContainer.vue";
export default {
    components: { InputContainer }
};
</script>
