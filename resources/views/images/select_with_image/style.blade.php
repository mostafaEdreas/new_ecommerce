 <style>
.dynamic-select {
  display: flex;
  box-sizing: border-box;
  flex-direction: column;
  position: relative;
  width: 100%;
  user-select: none;
}
.dynamic-select .dynamic-select-header {
  border: 1px solid #dee2e6;
  padding: 7px 30px 7px 12px;
}
.dynamic-select .dynamic-select-header::after {
  content: "";
  display: block;
  position: absolute;
  top: 50%;
  right: 15px;
  transform: translateY(-50%);
  background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' fill='%23949ba3' viewBox='0 0 16 16'%3E%3Cpath d='M8 13.1l-8-8 2.1-2.2 5.9 5.9 5.9-5.9 2.1 2.2z'/%3E%3C/svg%3E");
  height: 12px;
  width: 12px;
}
.dynamic-select .dynamic-select-header.dynamic-select-header-active {
  border-color: #c1c9d0;
}
.dynamic-select .dynamic-select-header.dynamic-select-header-active::after {
  transform: translateY(-50%) rotate(180deg);
}
.dynamic-select .dynamic-select-header.dynamic-select-header-active + .dynamic-select-options {
  display: flex;
}
.dynamic-select .dynamic-select-header .dynamic-select-header-placeholder {
  color: #65727e;
}
.dynamic-select .dynamic-select-options {
  display: none;
  box-sizing: border-box;
  flex-flow: wrap;
  position: absolute;
  top: 100%;
  left: 0;
  right: 0;
  z-index: 999;
  margin-top: 5px;
  padding: 5px;
  background-color: #fff;
  border-radius: 5px;
  box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
  max-height: 200px;
  overflow-y: auto;
  overflow-x: hidden;
}
.dynamic-select .dynamic-select-options::-webkit-scrollbar {
  width: 5px;
}
.dynamic-select .dynamic-select-options::-webkit-scrollbar-track {
  background: #f0f1f3;
}
.dynamic-select .dynamic-select-options::-webkit-scrollbar-thumb {
  background: #cdcfd1;
}
.dynamic-select .dynamic-select-options::-webkit-scrollbar-thumb:hover {
  background: #b2b6b9;
}
.dynamic-select .dynamic-select-options .dynamic-select-option {
  padding: 7px 12px;
}
.dynamic-select .dynamic-select-options .dynamic-select-option:hover, .dynamic-select .dynamic-select-options .dynamic-select-option:active {
  background-color: #f3f4f7;
}
.dynamic-select .dynamic-select-header, .dynamic-select .dynamic-select-option {
  display: flex;
  box-sizing: border-box;
  align-items: center;
  border-radius: 5px;
  cursor: pointer;
  display: flex;
  align-items: center;
  width: 100%;
  height: 45px;
  font-size: 16px;
  color: #212529;
}
.dynamic-select .dynamic-select-header img, .dynamic-select .dynamic-select-option img {
  object-fit: contain;
  max-height: 100%;
  max-width: 100%;
}
.dynamic-select .dynamic-select-header img.dynamic-size, .dynamic-select .dynamic-select-option img.dynamic-size {
  object-fit: fill;
  max-height: none;
  max-width: none;
}
.dynamic-select .dynamic-select-header img, .dynamic-select .dynamic-select-header svg, .dynamic-select .dynamic-select-header i, .dynamic-select .dynamic-select-header span, .dynamic-select .dynamic-select-option img, .dynamic-select .dynamic-select-option svg, .dynamic-select .dynamic-select-option i, .dynamic-select .dynamic-select-option span {
  box-sizing: border-box;
  margin-right: 10px;
}
.dynamic-select .dynamic-select-header.dynamic-select-no-text, .dynamic-select .dynamic-select-option.dynamic-select-no-text {
  justify-content: center;
}
.dynamic-select .dynamic-select-header.dynamic-select-no-text img, .dynamic-select .dynamic-select-header.dynamic-select-no-text svg, .dynamic-select .dynamic-select-header.dynamic-select-no-text i, .dynamic-select .dynamic-select-header.dynamic-select-no-text span, .dynamic-select .dynamic-select-option.dynamic-select-no-text img, .dynamic-select .dynamic-select-option.dynamic-select-no-text svg, .dynamic-select .dynamic-select-option.dynamic-select-no-text i, .dynamic-select .dynamic-select-option.dynamic-select-no-text span {
  margin-right: 0;
}
.dynamic-select .dynamic-select-header .dynamic-select-option-text, .dynamic-select .dynamic-select-option .dynamic-select-option-text {
  box-sizing: border-box;
  flex: 1;
  overflow: hidden;
  text-overflow: ellipsis;
  white-space: nowrap;
  color: inherit;
  font-size: inherit;
}

 </style>
