import React from "react";
import Ueditor from './Ueditor';
import {FormItem} from '@mxjs/a-form';

export default (props) => (
  <FormItem wrapperCol={{span: 12}} {...props}>
    <Ueditor/>
  </FormItem>
)

