#include<iostream>
using namespace std;

class Punto{
private:
     float x,y;
     public:
     Punto(float x,float y);Punto();
     float getx();
     float gety();
     void setx(float x);
     void sety(float y);
};
Punto::Punto(float x,float y){
    this->x=x;
    this->y=y;
}
Punto::Punto(){
    x=0;
    y=0;
}
float Punto::getx(){return x;}
float Punto::gety(){return y;}
void Punto::setx(float x){this->x=x;}
void Punto::sety(float y){this->y=y;}

class Linea{
    
    public:
    Punto p1,p2;
    Linea (Punto p1,Punto p2); Linea();
    float obtenerPendiente();
};
Linea::Linea(){
}
Linea::Linea(Punto p1,Punto p2){
    this->p1=p1;
    this->p2=p2;
}
float Linea::obtenerPendiente(){
    return (p2.gety()-p1.gety())/(p2.getx()-p1.getx());
}
bool seIntersectan(Linea l1,Linea l2){
    return l1.obtenerPendiente()!=l2.obtenerPendiente();
}
float puntoInterseccionX(Linea l1,Linea l2){
    return ((l1.p1.getx()*l1.p2.gety()-l1.p1.gety()*l1.p2.getx())*(l2.p1.getx()-l2.p2.getx())-(l1.p1.getx()-l1.p2.getx())*(l2.p1.getx()*l2.p2.gety()-l2.p1.gety()*l2.p2.getx()))
          /((l1.p1.getx()-l1.p2.getx())*(l2.p1.gety()-l2.p2.gety())-(l1.p1.gety()-l1.p2.gety())*(l2.p1.getx()-l2.p2.getx()));
}
float puntoInterseccionY(Linea l1,Linea l2){
    return ((l1.p1.getx()*l1.p2.gety()-l1.p1.gety()*l1.p2.getx())*(l2.p1.gety()-l2.p2.gety())-(l1.p1.gety()-l1.p2.gety())*(l2.p1.getx()*l2.p2.gety()-l2.p1.gety()*l2.p2.getx()))
          /((l1.p1.getx()-l1.p2.getx())*(l2.p1.gety()-l2.p2.gety())-(l1.p1.gety()-l1.p2.gety())*(l2.p1.getx()-l2.p2.getx()));
}
int main(){
    Punto p1(0,4),p2(4,0),p3(0,0),p4(4,4);
    Linea l1(p1,p2),l2(p3,p4);
    if(seIntersectan(l1,l2)){
        cout<<"El punto de interseccion es: ("<< puntoInterseccionX(l1,l2)<<","<<puntoInterseccionY(l1,l2) <<")"<<endl;
    }
    else{
        cout<<"las dos lineas no se intersectan";
    }
    return 0;
}



