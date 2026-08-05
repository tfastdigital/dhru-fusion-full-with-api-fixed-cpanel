var app = angular.module('pos',['ngRoute']);
var id =1;

//http://stackoverflow.com/questions/20177452/calculate-total-over-repeated-cart-item-totals-with-angular


app.controller('safeCtrl', ['$scope', function ($scope) {
   
   
   function generateItem(id,item,price,qnt,disc) {
        return {
            id: id,
            Item: item,
            Qnt: price,
            Price: qnt,
            Discount: disc
        }
    }
    
     $scope.rowCollection = [];
     $scope.removeItem = function removeItem(row) {
        var index = $scope.rowCollection.indexOf(row);
        if (index !== -1) {
            $scope.rowCollection.splice(index, 1);
        }
        $scope.displayedCollection = [].concat($scope.rowCollection);
    }
    
    
    $scope.addRandomItem = function addRandomItem() {
    
        $scope.rowCollection.push(generateItem(id,'test','1','1','19'));
        $scope.displayedCollection = [].concat($scope.rowCollection);
        id++;
    }
    //http://lorenzofox3.github.io/smart-table-website/
    
}]);


   
app.directive('ngEnter', function() {
    return function(scope, element, attrs) {
        element.bind('keydown', function(event) {
          if(event.which === 13) {
           
                scope.$apply(function (){
                      scope.$eval(attrs.ngEnter);
                      event.preventDefault();
                });
                
                event.preventDefault();
           }
        });
    };
})
.controller('posCntr', ['$scope','$http','$controller', function($scope,$http,$controller) {
    
 
    $scope.sub = function() {
        var sub = 0;
        angular.forEach($scope.displayedCollection, function(row) {
            sub += (row.Qnt*row.Price)-((row.Qnt*row.Price)*row.Discount/100);
        })
        return sub;
    }
  

  
    function generateItem(id,item,price,qnt,disc) {
        return {
            id: id,
            Item: item,
            Qnt: price,
            Price: qnt,
            Discount: disc
        }
    }
    $scope.rowCollection = [];
     
     
    $scope.postSerial = function() {
    
        var config = {
            params: {
              action: 'add',
              wid:1,
              serial:$scope.serial
            }
        };
     
 

        $scope.removeItem = function removeItem(row) {
            var index = $scope.rowCollection.indexOf(row);
            if (index !== -1) {
                $scope.rowCollection.splice(index, 1);
            }
           // $scope.displayedCollection = [].concat($scope.rowCollection);
        }
    
    
        //http://www.angularjshub.com/examples/forms/formsubmission/
        $http.post('includes/pages/pos.get.php',null,config)
        .success(function(data,status, headers,config) {
           
            $scope.result = [
                angular.fromJson(data)
            ];
            
            if(angular.equals($scope.result[0].status,'error')){
                $scope.RESULT=$scope.result[0].data;
            }else{
                
    $scope.RESULT="";
    if($scope.result[0].data.qnt>1)
    {
        $scope.rowCollection.splice($scope.result[0].data.id-1, 1);
        $scope.displayedCollection = [].concat($scope.rowCollection);
    }
    
    $scope.rowCollection.push(generateItem($scope.result[0].data.id,
    $scope.result[0].data.item,
    $scope.result[0].data.qnt,$scope.result[0].data.price,
    $scope.result[0].data.discount));
    
    $scope.displayedCollection = [].concat($scope.rowCollection);
    $scope.serial=""; 
                   
                   
            }
        })
        .error(function (data, status, headers, config)
        {
            alert(data+status);
        });
        
    }; 
   
     var config = {
            params: {
              action: 'tax'
            }
        };
        $scope.Taxes=[];
        $http.post('includes/pages/pos.get.php',null,config)
        .success(function(data,status, headers,config) {
           
            $scope.result = [
                angular.fromJson(data)
            ];
            
            angular.forEach($scope.result, function(tarr, ks) {
              
                angular.forEach(tarr, function(value, key) {
                    
                 
                    try{
                        
                        $scope.Taxes.push({
                            name: value.name,
                            rate: value.taxrate
                        });
                          
                    }catch(eg){
                        alert(eg);
                    }
                });
                
            });
        })
        .error(function (data, status, headers, config)
        {
            alert(data+status);
        });
   
     $scope.total = function() {
        var total = 0;
        angular.forEach($scope.displayedCollection, function(row) {
            total += (row.Qnt*row.Price)-((row.Qnt*row.Price)*row.Discount/100);
        })
        angular.forEach($scope.Taxes, function(tax) {
             total +=($scope.sub()*tax.rate/100);
        })
        return total;
    }     
           
           
 
}]);