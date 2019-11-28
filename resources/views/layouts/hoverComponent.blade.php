<style>
.objeto {
  position: relative;
  height: 200px;
  width: 400px;
}
.objetoOculto {
  position: absolute;
  top: 15px;
  bottom: 0;
  left: 0;
  right: 0;
  background: rgba(29, 106, 154, 0.72);
  color: #fff;
  visibility: hidden;
  opacity: 0;
}
.objeto:hover .objetoOculto {
  visibility: visible;
  opacity: 1;
}
</style>