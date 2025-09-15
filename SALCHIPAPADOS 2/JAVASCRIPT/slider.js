/** llama a los botones el carusel y a cada slider con su imagen */
const btnLeft= document.querySelector(".btn-left"),
      btnRight= document.querySelector(".btn-right"),
      slider=document.querySelector("#slider"),
      sliderSection=document.querySelectorAll(".slider-section");

btnLeft.addEventListener("click", e => GoLeft());  /*conecta el boton llamado anteriormente con la funcion*/     
btnRight.addEventListener("click", e => GoRight());  

let operacion=0,
contador=0,
widthImg= 100/sliderSection.length;/*Segun la cantidad de imagenes de hace la operacion*/ 

setInterval(()=>{/**Funcion para qeu se mueva el slider automaticamente */
GoRight();
},5000)/**Tiempo */


function GoRight(){
    if(contador >= sliderSection.length-1){
        contador=0;
        operacion=0;/**De devuelve a la primera imagen */
        slider.style.transform=`translate(-${operacion}%)`;/*Desde el id=slider pasa de una seccion(imagen) a otra*/ 
        slider.style.transition="none";
        return;
    }
        contador++;
        operacion=operacion+widthImg;/*suma las posiciones para seguir adelante*/ 
        slider.style.transform=`translate(-${operacion}%)`;/*Desde el id=slider pasa de una seccion(imagen) a otra*/ 
        slider.style.transition="all ease .6s";/*transicion*/ 
    
    
};      
function GoLeft(){
    contador--;
    if(contador<0){
        contador=sliderSection.length-1;
        operacion=widthImg*(sliderSection.length-1);
        slider.style.transform=`translate(-${operacion}%)`;/*Desde el id=slider pasa de una seccion(imagen) a otra*/ 
        slider.style.transition="none";
        return;
    }
    operacion=operacion - widthImg;/*resta las posiciones para atrasar*/ 
    slider.style.transform=`translate(-${operacion}%)`;/*Desde el id=slider pasa de una seccion a otra*/ 
    slider.style.transition="all ease .6s";/*transicion*/ 
};     