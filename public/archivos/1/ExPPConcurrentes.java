/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
package exppconcurrentes;
/**
 *
 * @author erwin
 */
public class ExPPConcurrentes {
    /**
     * @param args the command line arguments
     */
    public static void main(String[] args) {
        int[] carrito1={1,5,2,7,8};
        Cliente cliente1=new Cliente("Juan",carrito1);
        Caja caja1=new Caja(5,cliente1);
        
        int[] carrito2={5,2,9,1,3,11,76,4};
        Cliente cliente2=new Cliente("Pedro",carrito2);
        Caja caja2=new Caja(5,cliente2);
        caja1.start();
        caja2.start();
    }
}

class Cliente{
    private String nombre;
    private int carrito[];
    public String getNombre() {
        return nombre;
    }
    public void setNombre(String nombre) {
        this.nombre = nombre;
    }
    public int []getCarrito() {
        return carrito;
    }
    public void setCarrito(int []carrito) {
        this.carrito = carrito;
    }
    public Cliente(String nombre, int []carrito) {
        this.nombre = nombre;
        this.carrito = carrito;
    }
    
}

class Caja extends Thread{
    long tiempo;
    private Cliente c;
    public Caja(long tiempo, Cliente c){
        this.tiempo=tiempo;
        this.c=c;
    }
    
    @Override
    public void run(){
        System.out.println("Iniciando atencion a cliente "+ c.getNombre());
        for(int i=0;i<c.getCarrito().length;i++){
            try {
                this.sleep(tiempo*1000);
            } catch (InterruptedException ex) {
                //Logger.getLogger(Caja.class.getName()).log(Level.SEVERE, null, ex);
            }
            System.out.println("Producto "+i+". '"+c.getCarrito()[i]+"' registro a nombre de "+c.getNombre());  
        }
        System.out.println("Terminando atencion a cliente "+ c.getNombre());
    }
}