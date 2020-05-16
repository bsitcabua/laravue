<template>
    <div>
       <div class="content">
			<div class="container-fluid">
				<!--~~~~~~~ TABLE ONE ~~~~~~~~~-->
				<div class="_1adminOverveiw_table_recent _box_shadow _border_radious _mar_b30 _p20">
					<div class="_overflow">
						<p class="_title0 pull-left">Tags</p>
						<Button @click="showAddModal()" class="pull-right mb-2"><Icon type="md-add" /> Add tag</Button>
					</div>
					<div class="_overflow _table_div">
						<table class="_table">
								<!-- TABLE TITLE -->
							<tr>
								<th>ID</th>
								<th>Tag name</th>
								<th>Created at</th>
								<th style="text-align: center;">Action</th>
							</tr>
								<!-- TABLE TITLE -->
								<!-- ITEMS -->
							<tr v-for="(tag, i) in tags" :key="i" v-if="tags.length">
								<td>{{++i}}</td>
								<td class="_table_name">{{tag.tagName}}</td>
								<td>{{ tag.created_at | moment("MMMM DD YYYY, h:mm:ss a") }}</td>
								<td style="text-align: center;">
									<Button type="info" size="small" @click="showEditModal(tag, i)">Edit</Button>
									<Button type="error" size="small" @click="showDeletingModal(tag, i)">Delete</Button>
								</td>
							</tr>
								<!-- ITEMS -->
						</table>
					</div>
				</div>


				<!-- tag adding modal -->
				<Modal
					v-model="addModal"
					title="Add tag"
					:mask-closable="false"
					:closable="false"
				>
					<form @submit="storeTag" v-on:submit.prevent>
						<Input v-model="data.tagName" placeholder="Add tag name"  />
					</form>
					<div slot="footer">
						<Button type="default" @click="addModal=false">Close</Button>
						<Button type="primary" @click="storeTag" :disabled="isAdding" :loading="isAdding">{{isAdding ? 'Adding..' : 'Add tag'}}</Button>
					</div>
				</Modal>
				<!-- tag editing modal -->
				<Modal
					v-model="editModal"
					title="Edit tag"
					:mask-closable="false"
					:closable="false"
					>
					<form @submit="editTag" v-on:submit.prevent>
						<Input v-model="editData.tagName" placeholder="Edit tag name"  />
					</form>
					<div slot="footer">
						<Button type="default" @click="editModal=false">Close</Button>
						<Button type="primary" @click="editTag" :disabled="isEditing" :loading="isEditing">{{isEditing ? 'Editing..' : 'Edit tag'}}</Button>
					</div>

				</Modal>
				<!-- delete alert modal -->
				<Modal v-model="showDeleteModal" width="360">
					<p slot="header" style="color:#f60;text-align:center">
						<Icon type="ios-information-circle"></Icon>
						<span>Delete confirmation</span>
					</p>
					<div style="text-align:center">
						<p>Are you sure you want to delete tag?</p>
						<b>{{ deleteItem.tagName }}</b>
					</div>
					<div slot="footer">
						<Button type="error" size="large" long :loading="isDeleting" :disabled="isDeleting" @click="deleteTag" >{{ isDeleting ? "Deleting..." : "Delete" }}</Button>
					</div>
				</Modal>
				

			</div>
		</div>
    </div>
</template>


<script>
export default {
	data(){
		return {
			data : {
				tagName: ''
			}, 
			addModal : false, 
			editModal : false, 
			isAdding : false,
			isEditing : false,
			tags : [], 
			editData : {
				tagName: ''
			}, 
			index : -1, 
			showDeleteModal: false, 
			isDeleting : false,
			deleteItem: {}, 
		}
	},

	methods : {
		async getTags () {
			const res = await this.callApi('get', 'api/tags');
			const data = await res.data;
			if(data.status == 200){
				this.tags = data.tags;
			}else{
				this.swr();
			}
		},

		async storeTag(){
			if(this.data.tagName.trim()=='') return this.error('Tag name is required.', 'Required Field');
			this.isAdding = true;
			const res = await this.callApi('post', 'api/store-tag', this.data);
			const data = await res.data;
			if (data.status === 201) {
				this.tags = data.tags;
				this.success(data.msg);
				this.addModal = false;
				this.data.tagName = '';
			} else {
				if ( data.status == 422 && data.validator.tagName) {
					this.error(data.validator.tagName[0], 'Required Field');
				}
				else if( data.status == 409 ) {
					this.error(data.msg, 'Already Exist');
				} 
				else {
					this.swr(data.msg);
				}
			}
			this.isAdding = false;

		},
		async editTag(){
			if(this.editData.tagName.trim()=='') return this.error('Tag name is required.', 'Required Field');
			this.isEditing = true;
			const res = await this.callApi('post', 'api/update-tag', this.editData);
			const data = await res.data;
			if(data.status == 201){
				this.tags = data.tags;
				this.success(data.msg);
				this.editModal = false
			}else{
				if ( data.status == 422 && data.validator.tagName) {
					this.error(data.validator.tagName[0], 'Required Field');
				}
				else if( data.status == 409 ) {
					this.error(data.msg, 'Already Exist');
				} 
				else {
					this.swr(data.msg);
				}
			}
			this.isEditing = false;

		},
		showAddModal () {
			this.addModal = true;
			this.tagName = '';

		},
		showEditModal(tag, index){
			let obj = {
				id : tag.id,
				tagName : tag.tagName
			}
			this.editData = obj;
			this.editModal = true;
			this.index = index;

		}, 
		async deleteTag(){
			this.isDeleting = true
			const res = await this.callApi('post', 'api/destroy-tag', this.deleteItem);
			const data = await res.data;
			if(data.status == 200){
				this.tags = data.tags;
				this.success(data.msg);
				// this.success('Tag has been deleted successfully!');
				this.showDeleteModal = false
			}else{
				this.swr()
			}
			this.isDeleting = false
			
		}, 
		showDeletingModal(tag, i){
			this.deleteItem = tag;
			this.showDeleteModal = true;

		}
	}, 

	created(){
		// Call function tags
		this.getTags();
	}


	
}
</script>