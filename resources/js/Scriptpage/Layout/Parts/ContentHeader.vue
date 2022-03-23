<template>

      <!-- Content Header (Page header) -->
      <div class="content-header">

        <div v-if="pageTitle" class="container-fluid">

          <div class="row mb-2">
            <div class="col-sm-6">
              <h1 class="m-0">{{ pageTitle }}</h1>
            </div>

            <!-- /.col -->
            <div v-if="false" class="col-sm-6">
              <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="#">Home</a></li>
                <li class="breadcrumb-item active">Starter Page</li>
              </ol>
            </div>
            <!-- /.col -->

          </div>
          <!-- /.row -->

        </div>
        <!-- /.container-fluid -->

      </div>
      <!-- /.content-header -->
  
</template>

<script>
export default {

    props : {
        pageTitle: String
    }

}
</script>
