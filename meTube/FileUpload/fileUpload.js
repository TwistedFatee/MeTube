
$(function(){
	
	$("#demo").zyUpload({
		width            :   "650px",                 
		height           :   "400px",                 
		itemWidth        :   "120px",                 
		itemHeight       :   "100px",                 
		url              :   "/upload/UploadAction",  
		multiple         :   true,                    
		dragDrop         :   true,                    
		del              :   true,                    
		finishDel        :   false,  				  
		onSelect: function(files, allFiles){                    
			console.info("Now selecting the following files: ");
			console.info(files);
			console.info("Files haven't uploaded: ");
			console.info(allFiles);
		},
		onDelete: function(file, surplusFiles){                     
			console.info("Files have beening deleted: ");
			console.info(file);
			console.info("Remaining files: ");
			console.info(surplusFiles);
		},
		onSuccess: function(file){                    
			console.info("This file is failed to upload: ");
			console.info(file);
		},
		onFailure: function(file){                    
			console.info("This file is failed to upload: ");
			console.info(file);
		},
		onComplete: function(responseInfo){           
			console.info("Completed upload!");
			console.info(responseInfo);
		}
	});
});

