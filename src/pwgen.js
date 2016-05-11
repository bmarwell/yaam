		var keylist='eab6cxyz1dfgh89ijkop34qrs5tuvw27lmn'
		var temp=''
		
		function generatepass(plength)
		{
			temp = ''
			for ( i = 0; i < plength; i++ )
				temp += keylist.charAt( Math.floor( Math.random() * keylist.length ) )
			 
			return temp
		}
		
		function populateform(enterlength)
		{
			document.pgenerate.output.value = generatepass(enterlength)
		}