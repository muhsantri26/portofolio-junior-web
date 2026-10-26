
export class Stack { 
  constructor() { 
    this.items = []; 
  } 
 
  push(item) { 
    this.items.push(item); 
  } 
 
  pop() { 
    return this.isEmpty() ? undefined : this.items.pop(); 
  } 
 
  peek() { 
    return this.isEmpty() ? undefined : this.items[this.items.length - 1]; 
  } 
 
  isEmpty() { 
    return this.items.length === 0; 
  } 
 
 
  size() { 
    return this.items.length; 
  } 
 
  clear() { 
    this.items = []; 
  } 
}

export class Queue { 
  constructor() { 
    this.items = {}; 
    this.head = 0; 
    this.tail = 0; 
  } 
 
  enqueue(item) { 
    this.items[this.tail] = item; 
    this.tail++; 
  } 
 
  dequeue() { 
    if (this.isEmpty()) return undefined; 
    const item = this.items[this.head]; 
    delete this.items[this.head]; 
    this.head++; 
    return item; 
  } 
 
  front() { 
    return this.items[this.head]; 
  } 
 
 
  isEmpty() { 
    return this.tail === this.head; 
  } 
 
  size() { 
    return this.tail - this.head; 
  } 
} 